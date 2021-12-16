<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductionOrder;
use App\Models\Revenue;
use App\Models\Vendor;
use http\Client;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use phpDocumentor\Reflection\Types\Compound;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index()
    {
        $clientsCount = \App\Models\Client::count();
        $vendorsCount = Vendor::count();
        $billsTotal = Bill::sum('total');
        $paymentsTotal = Payment::whereHas('bill')->sum('amount');
        $invoicesTotal = Invoice::sum('total');
        $revenuesTotal = Revenue::whereHas('invoice')->sum('amount');
        $avgSalary = Employee::avg('salary');

        $salariesTotal =  Employee::sum('salary');

        $chart_options = [
            'chart_title' => 'Balance of Vendors',
            'chart_type' => 'bar',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\payment',

            'relationship_name' => 'vendor', // represents function elements() on Element model
            'group_by_field' => 'name', // users.name

            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',

            'filter_field' => 'created_at',
            'filter_days' => 30, // show only transactions for last 30 days
            'filter_period' => 'week', // show only transactions for this week
        ];
        $chart1 = new LaravelChart($chart_options);

        $chart_options2 = [
            'chart_title' => 'Revenues by weeks',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Revenue',
            'group_by_field' => 'paid_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 30, // show only last 30 days
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',

            'chart_title' => 'Balance of Clients',
            'chart_type' => 'line',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Revenue',
            'chart_color' => "#191919",

            'relationship_name' => 'client', // represents function orders() on User model
            'group_by_field' => 'name', // users.name

            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',

            'filter_field' => 'created_at',
            'filter_days' => 30, // show only transactions for last 30 days
            'filter_period' => 'week', // show only transactions for this week
        ];
        $chart2 = new LaravelChart($chart_options2);

        return view('home',compact('chart1','chart2',
            'clientsCount',
            'vendorsCount',
            'avgSalary',
            'salariesTotal',
            'billsTotal',
            'paymentsTotal',
            'invoicesTotal',
            'revenuesTotal',
        ));
    }

    public function notifications()
    {
        return view('notifications');
    }


    public function test()
    {
        $order = ProductionOrder::first();

        return view('vendor.invoices.pdf',compact('order'));
    }
}
