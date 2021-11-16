<?php

namespace App\Http\Controllers;

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
        $chart_options = [
            'chart_title' => 'Elements in Category',
            'chart_type' => 'bar',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Element',

            'relationship_name' => 'category', // represents function elements() on Element model
            'group_by_field' => 'name', // users.name

//            'aggregate_function' => 'sum',
//            'aggregate_field' => 'total',

            'filter_field' => 'created_at',
            'filter_days' => 30, // show only transactions for last 30 days
            'filter_period' => 'week', // show only transactions for this week
        ];
        $chart1 = new LaravelChart($chart_options);

//        $chart_options2 = [
//            'chart_title' => 'Balance of sellers',
//            'chart_type' => 'pie',
//            'report_type' => 'group_by_relationship',
//            'model' => 'App\Models\Order',
//            'chart_color' => "#191919",
//
//            'relationship_name' => 'user', // represents function orders() on User model
//            'group_by_field' => 'name', // users.name
//
//            'aggregate_function' => 'sum',
//            'aggregate_field' => 'total',
//
//            'filter_field' => 'created_at',
//            'filter_days' => 30, // show only transactions for last 30 days
//            'filter_period' => 'week', // show only transactions for this week
//        ];
//        $chart2 = new LaravelChart($chart_options2);
     //   dd($chart1);
        return view('home',compact('chart1'));
    }
}
