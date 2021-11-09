@extends('layouts.admin')

@section('content_header')
    <h1>Inventory</h1>
@stop

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('item-create')
                    <a href="{{route('items.insert')}}" class="btn btn-success">Insert Item</a>
                @endcan
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">


                                <livewire:tables.inventory-table />
            </div>
        </div>



@endsection

