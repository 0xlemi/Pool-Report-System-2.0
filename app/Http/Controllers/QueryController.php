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

    public function totalNotPaidThisMonth()
    {
        $company = Logged::company();
        $total = [];
        $currencies = config('constants.currencies');
        foreach ($currencies as $currency) {
            $total[$currency] = $company->services()
                                ->workOrders()->invoices()->unpaid()->thisMonth()
                                ->currency($currency)->sumSubtractingPayments();
        }
        dd($total);
    }

    public function allServicesWithSumOfThisMonthInvoicesRemovingPayments()
    {

        $company = Logged::company();
        $services =$company->services->transform(function($service){
            return (object)[
                'id' => $service->seq_id,
                'name' => $service->name,
                'balance' => $service->workOrders()->invoices()
                                        ->unpaid()->thisMonth()
                                        ->currency('USD')
                                        ->sumSubtractingPayments()
            ];
        });
        dd($services->toArray());
        // $service = $company->services()->bySeqId(5);
        // dd($service->workOrders()->invoices()->get()->toArray());

    }


}
