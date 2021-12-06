@extends('layouts.admin')

@section('content_header')
    <h1>Work Setting</h1>
@stop

@section('content')
    <div class="row justify-content-center ">
        <div class="col-lg-8 card">
            <div class="card-body">
                <form action="{{route('setting.store')}}" method="post">
                    @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="working_days">Working Days</label>
                        <input type="number" name="working_days" class="form-control" value="{{ setting('working_days') ?? old('working_days')}}">
                        @error('working_days')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours">Working Hours</label>
                        <input type="number" name="working_hours" class="form-control" value="{{ setting('working_hours') ?? old('working_hours')}}">
                        @error('working_hours')
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
