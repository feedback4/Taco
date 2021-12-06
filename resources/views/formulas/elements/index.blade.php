@extends('layouts.admin')

@section('content_header')
    <div class="">       <h2>All Elements</h2></div>
    <div class="">   <a href="{{route('formulas.compounds')}}" class="btn btn-outline-dark">Compounds</a></div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <livewire:tables.elements-table />

        </div>

            <div class="col-md-5">

                <livewire:forms.element-form />
            </div>

    </div>


@endsection


