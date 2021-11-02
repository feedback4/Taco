@extends('layouts.app')

@section('content')

<div class="login-box justify-content-center row">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary col-lg-3 col-md-5 col-sm-6">
        <div class="card-header text-center">
            <div class="h1"><b>Taco</b> system</div>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your magic</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group mb-3">
                     <input id="email" type="email"  placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bx bx-envelope bx-xs"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password"  placeholder="Enter Your password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bx bx-lock bx-xs"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 d-flex justify-content-between " >
                    <div class=" ml-4">
                            <input class=" form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label "  for="remember">
                                {{ __('auth.remember') }}
                            </label>
                    </div>
                    <!-- /.col -->
                    <div class="">
                        <button type="submit" class="btn btn-primary">
                            {{ __('auth.login') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center mt-2 mb-3">
{{--                <a href="#" class="btn btn-block btn-primary">--}}
{{--                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
{{--                </a>--}}
                <a href="{{ url('auth/redirect') }}" class="btn btn-block btn-danger d-flex justify-content-center">
                    <i class="bx bxl-google-plus bx-sm mr-2"></i>
                    <span>Sign in using Google+</span>
                </a>
            </div>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('auth.forgetpass') }}
                    </a>
                @endif
            </p>
{{--            <p class="mb-0">--}}
{{--                <a href="{{route('register')}}" class="text-center">Register a new membership</a>--}}
{{--            </p>--}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@stop


{{--<form method="POST" action="{{ route('login') }}">--}}
{{--    @csrf--}}

{{--    <div class="form-group row">--}}
{{--        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.email') }}</label>--}}

{{--        <div class="col-md-6">--}}
{{--            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--            @error('email')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group row">--}}
{{--        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.pass') }}</label>--}}

{{--        <div class="col-md-6">--}}
{{--            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--            @error('password')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group row">--}}
{{--        <div class="col-md-6 offset-md-4">--}}
{{--            <div class="form-check">--}}
{{--                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                <label class="form-check-label" for="remember">--}}
{{--                    {{ __('auth.remember') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group row mb-0">--}}
{{--        <div class="col-md-8 offset-md-4">--}}
{{--            <button type="submit" class="btn btn-primary">--}}
{{--                {{ __('auth.login') }}--}}
{{--            </button>--}}

{{--            @if (Route::has('password.request'))--}}
{{--                <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                    {{ __('auth.forgetpass') }}--}}
{{--                </a>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <a href="{{ url('auth/redirect') }}" style="margin-top: 20px;" class="btn btn-danger  mx-auto">--}}
{{--            <strong>Login With Google</strong>--}}
{{--        </a>--}}
{{--    </div>--}}

{{--</form>--}}

