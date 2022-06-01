@extends('layouts.admin')

@section('content_header')

      <h1>Create Transfer Order </h1>
     <a href="{{route('inventory.transfer-orders.index')}}" class="btn btn-dark">All Transfer Orders</a>
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
                <livewire:forms.transfer-orders-form    />
            </div>
        </div>

@endsection


