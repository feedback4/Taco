@extends('layouts.admin')

@section('content_header')
    <h2>Customer relationship management</h2>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">



            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


        </div>

    </div>



@endsection


