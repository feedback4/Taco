@extends('layouts.admin')

@section('content_header')
<h1>Compounds</h1>
<a href="{{route('formulas.elements.index')}}"></a>
@stop

@section('content')

    <div class="row ">

            <div class="col-md-12 mb-4">
                <livewire:forms.compounds-form/>
            </div>

            <div class="col-md-12 ">
                <livewire:tables.compounds-table/>
            </div>

    </div>
@endsection
