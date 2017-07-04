<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PRS\Classes\Logged;

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
    public function allServicesWithSumOfThisMonthContractInvoicesSubtractingPayments(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
        ]);

        $limit = ($request->limit)?: 10;

        $company = Logged::company();
        $servicesPaginated = $company->services()->paginate($limit);
        $services = $servicesPaginated->transform(function($service){
            $price = 'no contract';
            $total = 'no contract';
            if($contract = $service->serviceContract){
                $price = $contract->price;
                $total = [];
                // $currencies = config('constants.currencies');
                // foreach ($currencies as $currency) {
                //     $services = $contract->invoices()
                //                             ->unpaid()->thisMonth()
                //                             ->currency($currency);
                //     $invoicesTotal = $services->sum('invoices.amount');
                //     $paymentTotal = $services->join('payments', 'invoices.id', '=', 'payments.invoice_id')->sum('payments.amount');
                //     $total[$currency] = round($invoicesTotal - $paymentTotal, 2);
                // }
            }
            return (object)[
                'id' => $service->seq_id,
                'name' => $service->name,
                'address' => $service->address_line,
                'price' => $price,
                // 'contract_balance' => $total
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
    public function allServicesWithSumOfThisMonthWorkOrdersInvoicesSubtractingPayments()
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
