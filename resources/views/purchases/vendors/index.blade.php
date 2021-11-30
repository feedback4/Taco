@extends('layouts.admin')

@section('content_header')
    <h1>All Vendors</h1>
    <a href="{{route('purchases.vendors.create')}}" class="btn btn-success">Create Vendor</a>
@stop

@section('content')

    <div class="row ">
        <div class="col-md-8">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.vendors-table />
        </div>
    </div>



@endsection


