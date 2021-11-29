@extends('layouts.admin')

@section('content_header')
    <h1>Insert Items</h1>
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <livewire:forms.items-insert :inventoryId="$id" />
        </div>
    </div>



@endsection



