@extends('layouts.admin')

@section('content_header')
    <h1>Invoices Setting</h1>
@stop

@section('content')
    <div class="row justify-content-center ">
        <div class="col-lg-8 card">
            <div class="card-body">
                <form action="{{route('setting.store')}}" method="post">
                    @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="number_prefix">Number Prefix</label>
                        <input type="text" name="number_prefix" class="form-control"  value="{{ setting('number_prefix') ?? old('number_prefix')}}">
                        @error('number_prefix')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="due_to_days">Due To Days</label>
                        <input type="number" name="due_to_days" class="form-control"  value="{{ setting('due_to_days') ?? old('due_to_days')}}">
                        @error('due_to_days')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="notes">Notes</label>
                        <input type="text" name="notes" class="form-control"  value="{{ setting('notes') ?? old('notes')}}">
                        @error('notes')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="footer">Footer</label>
                        <input type="text" name="footer" class="form-control"  value="{{ setting('footer') ?? old('footer')}}">
                        @error('footer')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="show_item_description">Show Item Description</label>
                        <input type="checkbox" name="hide_item_description" class="form-control"  value="{{ setting('show_item_description') ?? old('show_item_description')}}">
                        @error('show_item_description')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="show_logo">Show Logo</label>
                        <input type="checkbox" name="show_logo" class="form-control"  value="{{ setting('show_logo') ?? old('show_logo')}}">
                        @error('show_logo')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="color">Color</label>
                        <input type="color" name="color" class="form-control"  value="{{ setting('color') ?? old('color')}}">
                        @error('color')
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
