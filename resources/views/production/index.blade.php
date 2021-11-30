@extends('layouts.admin')

@section('content_header')

    <div class="">    <h1>Production Plans</h1></div>
    <div class="">   <a href="{{route('production.create')}}" class="btn btn-primary">Place Order</a></div>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <livewire:tables.production-table />

        </div>
    </div>



@endsection


