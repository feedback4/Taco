@extends('layouts.admin')

@section('content_header')
    <h1>Purchasing</h1>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('item-purchase')
                <a href="{{route('items.purchase')}}" class="btn btn-success">purchase Item</a>
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

            <livewire:forms.items-insert />

        </div>
    </div>



@endsection


