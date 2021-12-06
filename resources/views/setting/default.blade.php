@extends('layouts.admin')

@section('content_header')
    <h1>Default Setting</h1>
@stop

@section('content')
    <div class="row justify-content-center ">
        <div class="col-lg-8 card">
            <div class="card-body">
                <form action="{{route('setting.store')}}" method="post">
                    @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="language">Language</label>
                        <input type="text" name="language" class="form-control" value="{{ setting('language') ?? old('language')}}">
                        @error('language')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="currency">Currency</label>
                        <input type="text" name="currency" class="form-control" value="{{ setting('currency') ?? old('currency')}}">
                        <select name="" id="">
                            @foreach($currencies as $curren)

                            @endforeach
                        </select>
                        @error('currency')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="default_tax">Tax</label>
                        <input type="text" name="default_tax" class="form-control" value="{{ setting('default_tax') ?? old('v')}}">
                        @error('default_tax')
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
