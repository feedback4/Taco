@extends('layouts.admin')

@section('title', 'Import')

@section('content_header')
    <h1>Import</h1>
@stop

@section('content')

<div class="row  d-flex justify-content-between ">
    <div class="card  flex-md-fill m-1 ">
        <h3 class="card-header">Clients</h3>
        <form action="{{ route('import.clients') }}" method="POST" enctype="multipart/form-data" class="card-body">
            @csrf
            <a class="btn btn-dark" href="{{ route('template.clients') }}">Download Template</a>
            <hr>
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="clients" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                @error('clients')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <button class="btn btn-primary">Import data</button>
{{--            <a class="btn btn-success" href="{{ route('import') }}">Export data</a>--}}
        </form>
    </div>

    <div class="card flex-md-fill m-1">
        <h3 class="card-header">Companies</h3>
        <form action="{{ route('import.companies') }}" method="POST" enctype="multipart/form-data" class="card-body">
            @csrf
            <a class="btn btn-dark" href="{{ route('template.companies') }}">Download Template</a>
            <hr>
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="companies" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            @error('companies')
            <small class="text-danger">{{$message}}</small>
            @enderror
            <button class="btn btn-primary">Import data</button>
{{--            <a class="btn btn-success" href="{{ route('import') }}">Export data</a>--}}
        </form>
    </div>
    <div class="card flex-md-fill m-1">
        <h3 class="card-header">Vendors</h3>
        <form action="{{ route('import.vendors') }}" method="POST" enctype="multipart/form-data" class="card-body">
            @csrf
            <a class="btn btn-dark" href="{{ route('template.vendors') }}">Download Template</a>
            <hr>
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="vendors" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                @error('vendors')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <button class="btn btn-primary">Import data</button>
{{--            <a class="btn btn-success" href="{{ route('') }}">Export data</a>--}}
        </form>
    </div>
</div>




@endsection


