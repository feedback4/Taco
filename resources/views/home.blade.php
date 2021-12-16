@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

        <!-- Earnings (Monthly) Card Example -->

        <div class="col mb-2">
            <div class="card text-white bg-gradient-blue ">
                <div class="card-header">Sales Incomes</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{route('sales.revenues.index')}}" class="text-white">{{$revenuesTotal}} {{setting('currency') ?? 'EGP'}}</a>

                    </h5>
                    @if($invoicesTotal - $revenuesTotal)
                    <small>open Invoices: {{$invoicesTotal - $revenuesTotal}} to collect</small>
                    @else
                        <small>nothing to collect</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col mb-2">
            <div class="card text-white bg-gradient-red ">
                <div class="card-header">Purchases Expenses</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{route('purchases.payments.index')}}" class="text-white">{{$paymentsTotal}} {{setting('currency') ?? 'EGP'}}</a>

                    </h5>
                    @if($billsTotal - $paymentsTotal)
                        <small>open Bills: {{$billsTotal - $paymentsTotal}} to pay</small>
                    @else
                        <small>nothing to pay</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col mb-2">
            <div class="card text-white bg-gradient-gray ">
                <div class="card-header">Total Salaries</div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{route('hr.employees.index')}}" class="text-white">{{$salariesTotal}} {{setting('currency') ?? 'EGP'}}</a>

                    </h5>
                    @if($avgSalary)
                        <small>with Avg {{$avgSalary}} EGP</small>
                    @else
                        <small>Add Employee Salaries</small>
                    @endif
                </div>
            </div>
        </div>

        <div class="col mb-2">
            @if(($invoicesTotal - $billsTotal -$salariesTotal) > 0)
            <div class="card text-white bg-gradient-green ">
                <div class="card-header">Total Profits</div>
                <div class="card-body">
                    <h5 class="card-title"><span class="text-white">{{$invoicesTotal - $billsTotal -$salariesTotal}} {{setting('currency') ?? 'EGP'}}</span>
                    </h5>
                </div>
            </div>
            @else
                <div class="card text-white bg-gradient-dark ">
                    <div class="card-header">Total Loses</div>
                    <div class="card-body">
                        <h5 class="card-title"><span class="text-white">{{$billsTotal - $invoicesTotal + $salariesTotal }} {{setting('currency') ?? 'EGP'}}</span>
                        </h5>
                    </div>
                </div>
            @endif
        </div>





    </div>
    <div class="row">

        @if($vendorsCount > 2)
        <div class="col-md-6 ">
                        <h2>{{ $chart1->options['chart_title'] }}</h2>
                        {!! $chart1->renderHtml() !!}
        </div>
        @endif
        @if($clientsCount > 2)
                <div class="col-md-6 ">
                    <h2>{{ $chart2->options['chart_title'] }}</h2>
                    {!! $chart2->renderHtml() !!}
                </div>
            @endif
    </div>

@endsection

@push('js')
        {!! $chart1->renderChartJsLibrary() !!}

        {!! $chart1->renderJs() !!}
        {!! $chart2->renderJs() !!}

@endpush
