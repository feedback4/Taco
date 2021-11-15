@extends('layouts.admin')

@section('content_header')

@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h2>All Elements</h2>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.elements-table />

        </div>
        @can('element-create')
            <div class="col-md-5">
                <div class="my-2">
                    <a href="{{route('compounds')}}" class="btn btn-outline-dark">Compounds</a>
                </div>
                <livewire:forms.element-form />
            </div>

        @endcan
    </div>


@endsection


