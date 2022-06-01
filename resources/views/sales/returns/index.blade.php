@extends('layouts.admin')

@section('content_header')
        <h1>All Returns</h1>
        <a href="{{route('sales.returns.create')}}" class="btn btn-success">Create Return</a>
@stop

@section('content')

    <div class="row ">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.returns-table />
        </div>
    </div>

@endsection


