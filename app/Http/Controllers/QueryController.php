<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PRS\Classes\Logged;
use DB;
use PDF;
use Uuid;
use Excel;
use Carbon\Carbon;

class QueryController extends PageController
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function totalNotPaidThisMonth()
    // {
    //     $company = Logged::company();
    //     $total = [];
    //     $currencies = config('constants.currencies');
    //     foreach ($currencies as $currency) {
    //         $total[$currency] = $company->services()
    //                             ->workOrders()->invoices()->unpaid()->thisMonth()
    //                             ->currency($currency)->sumSubtractingPayments();
    //     }
    //     dd($total);
    // }

        // NEEDS TO OPTIMIZE
    public function servicesContractMonthlyBalance(Request $request)
    {
        $filter = $this->serviceContractFilter($request);
        // Paginate
        $servicesPaginated = $filter->services->paginate($filter->limit);

        $services = $this->serviceContractTrasformer($servicesPaginated, $filter->month, $filter->year, $filter->onTime);

        $data = array_merge(
            [
                'data' => $services,
                'total_charged' =>  $this->getTotalChargedServiceContract($request),
                'total_paid' => $this->getTotalPaidServiceContract($request, $filter)
            ],
            [
                'paginator' => [
                    'total' => $servicesPaginated->total(),
                    'per_page' => $servicesPaginated->perPage(),
                    'current_page' => $servicesPaginated->currentPage(),
                    'last_page' => $servicesPaginated->lastPage(),
                    'next_page_url' => $servicesPaginated->nextPageUrl(),
                    'prev_page_url' => $servicesPaginated->previousPageUrl(),
                    'from' => $servicesPaginated->firstItem(),
                    'to' => $servicesPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
    }

    public function servicesContractMonthlyBalanceExcel(Request $request)
    {
        $filter = $this->serviceContractFilter($request);
        $data = $this->serviceContractTrasformer($filter->services->get(), $filter->month, $filter->year, $filter->onTime, false);
        $data = $data->toArray();

        $totalCharged = $this->getTotalChargedServiceContract($request);
        $totalPaid = $this->getTotalPaidServiceContract($request, $filter);

        // add total charged
        $data = array_merge(
                    $data,
                    [['']],
                    [array_merge(['Total Charged', ''], config('constants.currencies'))],
                    [array_merge(['', ''], array_values($totalCharged)) ]
                );

        // add total paid
        $data = array_merge(
                    $data,
                    [['']],
                    [array_merge(['Total Paid', ''], config('constants.currencies'))],
                    [array_merge(['', ''], array_values($totalPaid))]
                );


        $uuid = Uuid::generate();
        $excel = Excel::create($uuid, function($excel) use ($data){

            // Call writer methods here
            $excel->sheet('services', function($sheet) use ($data){

                $sheet->fromArray($data);

            });

        })->export('xlsx');
    }

    public function servicesContractMonthlyBalancePDF(Request $request)
    {
        $filter = $this->serviceContractFilter($request);
        $data = $this->serviceContractTrasformer($filter->services->get(), $filter->month, $filter->year, $filter->onTime);
        $totalCharged = $this->getTotalChargedServiceContract($request);
        $totalPaid = $this->getTotalPaidServiceContract($request, $filter);
        $onTimeText = 'all';
        if(!($filter->onTime == null)){
            $onTimeText = 'late';
            if($filter->onTime){
                $onTimeText = 'on-time';
            }
        }
        $contractText = '';
        if(!($filter->contract == null)){
            $contractText = '(No Contract or Inactive)';
            if($filter->contract){
                $contractText = '(Active Contract)';
            }
        }
        $monthText = Carbon::createFromDate(null , $filter->month)->format('F');
        $titles = [
            '#',
            'Name',
            'Address',
            'Monthly Price',
            "Sum of {$onTimeText} Payments of {$monthText}"
        ];
        $attributes = [
            'id',
            'name',
            'address',
            'price',
            'payments_month'
        ];
        // return view('pdf.basicTable', compact('attributes', 'titles', 'data', 'contractText', 'totalCharged', 'totalPaid'));
        $pdf = PDF::loadView('pdf.basicTable', compact('attributes', 'titles', 'data', 'contractText', 'totalCharged', 'totalPaid'));
        return $pdf->inline();
    }

    protected function getTotalChargedServiceContract(Request $request)
    {
        $currencies = config('constants.currencies');
        $total = [];
        foreach ($currencies as $currency) {
            $total[$currency] = $this->serviceContractFilter($request)->services->contracts()
                                            ->currency($currency)->active(true)->sum('service_contracts.amount');
        }
        return $total;
    }

    protected function getTotalPaidServiceContract(Request $request, $filter)
    {
        $currencies = config('constants.currencies');
        $total = [];
        foreach ($currencies as $currency) {
            $tempTotal= $this->serviceContractFilter($request)->services->contracts()->invoices()
                                            ->unpaid()->onMonth($filter->month, $filter->year)
                                            ->currency($currency)->payments();
            if($filter->onTime == null){
                $total[$currency] = $tempTotal->sum('payments.amount');
            }else{
                $total[$currency] = $tempTotal->onTime($filter->onTime)->sum('payments.amount');
            }
        }
        return $total;
    }

    protected function serviceContractFilter(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'contract' => 'boolean',
            'month' => 'required_with:year|integer|between:1,12',
            'year' => 'required_with:month|integer|between:2016,2050',
            'ontime' => 'boolean'
        ]);

        $limit = ($request->limit)?: 10;

        $company = Logged::company();

        $month = Carbon::today($company->timezone)->month;
        $year = Carbon::today($company->timezone)->year;
        if($request->has('month')){
            $month = $request->month;
            $year = $request->year;
        }

        if(!$request->has('contract')){ // If they dont send anything then all services
            $allServices = $company->services();
        }elseif($request->contract){ // if they send contract as true only active contracts
            $allServices = $company->services()->withActiveContract();
        }else{ // if they send contract as false only inactive contracts
            $allServices = $company->services()->withoutActiveContract();
        }

        // Filter by search
        if($request->filter){
            $escapedInput = str_replace('%', '\\%', $request->filter);
            $allServices = $allServices->where('services.name', 'ilike', '%'.$escapedInput.'%' )
                                    ->orWhere('services.address_line', 'ilike', '%'.$escapedInput.'%');
        }
        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $allServices = $allServices->orderBy($sort[0], $sort[1]);
        }

        return (object)[
            'services' => $allServices,
            'month' => $month,
            'year' => $year,
            'limit' => $limit,
            'onTime' => $request->ontime,
            'contract' => $request->contract
        ];
    }

    protected function serviceContractTrasformer($query, $month, $year, $onTime = null, $object = true)
    {
        return $query->transform(function($service) use ($month, $year, $onTime, $object){
            $price = 'No Contract';
            $total = 'None';
            // If has Contract make all the balance math if not don't bother
            if($contract = $service->serviceContract){
                // Check if the contract is inactive
                $price = "Inactive";
                if($contract->active){
                    $price = $contract->price;
                }
                // $total = [];
                $total = '';
                // Need to do the math for each supported currency
                $currencies = config('constants.currencies');
                foreach ($currencies as $currency) {
                    // Get all the invoices that are for the month
                    $invoices = $contract->invoices()
                                            ->unpaid()->onMonth($month, $year)
                                            ->currency($currency);
                    // Sum the amount of the invoices
                    // $invoicesTotal = $invoices->sum('invoices.amount');

                    // Get all the Payments from that invoice
                    $payments = $invoices->payments();
                    if(!($onTime == null)){
                        // Filtern depending if they where done on time or not
                        $payments = $payments->onTime( (boolean) $onTime);
                    }
                    $paymentTotal  = $payments->sum('payments.amount');
                    // Get the balance
                    // $currencyTotal = round($invoicesTotal - $paymentTotal, 2);
                    // If is more than zero add it to the string
                    if($paymentTotal > 0){
                        $total .= $paymentTotal." ".$currency.", ";
                    }
                    // $total[$currency] = round($invoicesTotal - $paymentTotal, 2);
                }
                if($total == ''){
                    $total = 'None';
                }else{
                    $total = rtrim($total,", ");
                }
            }
            $result = [
                'id' => $service->seq_id,
                'name' => $service->name,
                'address' => $service->address_line,
                'price' => $price,
                'payments_month' => $total
            ];
            if($object){
                return (object) $result;
            }
            return $result;
        });
    }



    // NEEDS TO OPTIMIZE
    public function servicesWorkOrderMonthlyBalance()
    {
        $company = Logged::company();
        $services =$company->services->transform(function($service){

            $total = [];
            $currencies = config('constants.currencies');
            foreach ($currencies as $currency) {
                $services = $service->workOrders()->invoices()
                                        ->unpaid()->thisMonth()
                                        ->currency($currency);
                $invoicesTotal = $services->sum('invoices.amount');
                $paymentTotal = $services->join('payments', 'invoices.id', '=', 'payments.invoice_id')->sum('payments.amount');
                $total[$currency] = round($invoicesTotal - $paymentTotal, 2);
            }

            $price = 'no contract';
            if($contract = $service->serviceContract){
                $price = $contract->price;
            }
            return (object)[
                'id' => $service->seq_id,
                'name' => $service->name,
                'address' => $service->address_line,
                'price' => $price,
                'work_orders_balance' => $total
            ];
        });

        return response()->json($services);
    }


}
