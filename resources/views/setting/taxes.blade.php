@extends('layouts.admin')

@section('content_header')
    <h1>Taxes</h1>
@stop

@section('content')
    <div class="row justify-content-center ">
        <div class="col-lg-8 card">
            <div class="card-body">
                <form action="{{route('setting.store')}}" method="post">
                    @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name">Tax Name</label>
                        <input type="text" name="name" class="form-control">
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="percent">Tax percent</label>
                        <input type="number" name="percent" class="form-control">
                        @error('percent')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn bg-gradient-green text-white w-100 h4 mt-4">
                        Save
                    </button>

                </div>
                </form>
            </div>

        </div>
    </div>
@endsection
