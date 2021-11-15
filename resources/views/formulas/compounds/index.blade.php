@extends('layouts.admin')

@section('content_header')
@stop

@section('content')

    <div class="row ">
        @can('element-create')
            <div class="col-md-12 mb-4">
                <livewire:forms.compounds-form/>
            </div>
        @endcan
        @can('element-show')
            <div class="col-md-12 ">
                <livewire:tables.compounds-table/>
            </div>
        @endcan
    </div>
@endsection
