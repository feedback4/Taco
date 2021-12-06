@extends('layouts.admin')

@section('content_header')
        <h1>All Payments</h1>
        <a href="{{route('purchases.payments.create')}}" class="btn btn-success">Add Payment</a>
@stop

@section('content')

    <div class="row ">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.payments-table />
        </div>
    </div>

@endsection


