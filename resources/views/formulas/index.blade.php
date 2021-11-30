@extends('layouts.admin')

@section('content_header')
    <div class="">
        <h2>All Formulas</h2>
    </div>
    <div class="">
        <a href="{{route('formulas.formulas.create')}}" class="btn btn-success">Create Formula</a>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">




            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.formulas-table />

        </div>

    </div>



@endsection


