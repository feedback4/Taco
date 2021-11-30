@extends('layouts.admin')

@section('content_header')
    <h1>All Products</h1>
    <a href="{{route('production.create')}}" class="btn btn-success">place Order</a>
@stop

@section('content')

    <div class="row ">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-7">
            <livewire:tables.products-table />
        </div>
        <div class="col-md-5">
            <livewire:forms.product-form />
        </div>
    </div>



@endsection


