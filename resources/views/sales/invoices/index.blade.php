@extends('layouts.admin')

@section('content_header')
    <div class="">
        <h1>All Invoices</h1>
    </div>
    <div class="">
        <a href="{{route('sales.invoices.create')}}" class="btn btn-success">Create Invoice</a>
    </div>

@stop

@section('content')

    <div class="row ">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.invoices-table />
        </div>
    </div>

@endsection


