<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PRS\Classes\Logged;
use DB;
use PDF;
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

    public function servicesContractMonthlyBalancePDF()
    {
        $company = Logged::company();
        $data = $company->services->transform(function($service){
            $price = 'No Contract';
            $total = 'No Contract';
            if($contract = $service->serviceContract){
                $price = $contract->price;
                // $total = [];
                $total = '';
                $currencies = config('constants.currencies');
                foreach ($currencies as $currency) {
                    $services = $contract->invoices()
                                            ->unpaid()->thisMonth()
                                            ->currency($currency);
                    $invoicesTotal = $services->sum('invoices.amount');
                    $paymentTotal = $services->join('payments', 'invoices.id', '=', 'payments.invoice_id')->sum('payments.amount');
                    $currencyTotal = round($invoicesTotal - $paymentTotal, 2);
                    if($currencyTotal > 0){
                        $total .= $currencyTotal." ".$currency.", ";
                    }
                    // $total[$currency] = round($invoicesTotal - $paymentTotal, 2);
                }
                if($total == ''){
                    $total = 'All Paid';
                }else{
                    $total = rtrim($total,", ");
                }
            }
            return (object)[
                'id' => $service->seq_id,
                'name' => $service->name,
                'address' => $service->address_line,
                'price' => $price,
                'contract_balance' => $total
            ];
        });
         $titles = [
            '#',
            'Name',
            'Address',
            'Monthly Price',
            'Monthly Balance'
        ];
        $attributes = [
            'id',
            'name',
            'address',
            'price',
            'contract_balance'
        ];
        // return view('pdf.basicTable', compact('attributes', 'titles', 'data'));
        $pdf = PDF::loadView('pdf.basicTable', compact('attributes', 'titles', 'data'));
        return $pdf->inline();
    }

    // NEEDS TO OPTIMIZE
    public function servicesContractMonthlyBalance(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'contract' => 'boolean',
            'month' => 'required_with:year|integer|between:1,12',
            'year' => 'required_with:month|integer|between:2016,2050'
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
        // Paginate
        $servicesPaginated = $allServices->paginate($limit);
        $services = $servicesPaginated->transform(function($service) use ($month, $year){
            $price = 'No Contract';
            $total = 'All Paid';
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
                    // Sum the amount of the payments in all the invoices
                    $paymentTotal = $invoices->join('payments', 'invoices.id', '=', 'payments.invoice_id')->sum('payments.amount');
                    // Get the balance
                    // $currencyTotal = round($invoicesTotal - $paymentTotal, 2);
                    // If is more than zero add it to the string
                    if($paymentTotal > 0){
                        $total .= $paymentTotal." ".$currency.", ";
                    }
                    // $total[$currency] = round($invoicesTotal - $paymentTotal, 2);
                }
                if($total == ''){
                    $total = 'All Paid';
                }else{
                    $total = rtrim($total,", ");
                }
            }
            return (object)[
                'id' => $service->seq_id,
                'name' => $service->name,
                'address' => $service->address_line,
                'price' => $price,
                'payments_month' => $total
            ];
        });


        $data = array_merge(
            [
                'data' => $services
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
