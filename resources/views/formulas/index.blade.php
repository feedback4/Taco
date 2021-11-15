@extends('layouts.admin')

@section('content_header')
    <h2>All Formulas</h2>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">

            @can('formula-create')
                <a href="{{route('formulas.create')}}" class="btn btn-success">Create Formula</a>
            @endcan
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.formulas-table />

        </div>

    </div>



@endsection


