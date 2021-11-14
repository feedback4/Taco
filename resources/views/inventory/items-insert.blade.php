@extends('layouts.admin')

@section('content_header')
    <h1>Insert Item</h1>
@stop

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('item-insert')
                    <a href="{{route('inventory')}}" class="btn btn-success">Inventory</a>
                @endcan
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


            </div>
        </div>


@endsection


