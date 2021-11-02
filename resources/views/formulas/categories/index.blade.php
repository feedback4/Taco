@extends('layouts.admin')

@section('content_header')

@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h2>All Categories</h2>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.categories-table />

        </div>
        @can('user-create')
            <div class="col-md-5">
                <livewire:forms.category-form />
            </div>

        @endcan
    </div>


@endsection


