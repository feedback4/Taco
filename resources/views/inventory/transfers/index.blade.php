@extends('layouts.admin')

@section('content_header')

      <h1>Transfer Orders </h1>
     <a href="{{route('inventory.transfer-orders.create')}}" class="btn btn-dark">Create Transfer</a>
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
                <livewire:tables.transfer-orders-table   />
            </div>
        </div>

@endsection


