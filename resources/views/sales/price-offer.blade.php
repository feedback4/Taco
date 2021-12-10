@extends('layouts.admin')

@section('content_header')
    <h1>Price Offer</h1>
    <a href="{{route('sales.invoices.create')}}" class="btn btn-success">Create Invocie</a>
@stop

@section('content')

    <div class="row ">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
{{--            <livewire:tables.revenues-table />--}}
        </div>
    </div>

@endsection


