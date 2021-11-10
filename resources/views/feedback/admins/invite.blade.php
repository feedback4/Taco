@extends('feedback.layouts.feedback')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Invite Admin</h1>
@stop
@section('content')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{route('feedback.roles.index')}}">Manage Roles</a>
                <a href="{{ route('feedback.admins.index') }}" class="btn btn-outline-primary">All Admins</a>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('feedback.admins.send') }}">
                    @csrf
                    <div class="form-group row">

                        <div class="col-md-6">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="role" class=" col-form-label text-md-right">Role</label>
                            <select name="role" class="form-select" aria-label="Default select example" >
                                @foreach($roles as $role)
                                    <option value="{{$role}}">{{$role}}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-10">
                            <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
                            <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password"  >

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
@endsection

