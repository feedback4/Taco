@extends('feedback.layouts.feedback')

@section('content_header')
    <h1>Create Role</h1>
@stop
@section('content')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{route('feedback.roles.index')}}">Manage Roles</a>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('feedback.roles.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Role Name</label>

                        <div class="col-md-6">
                            <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('role') }}"  autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            @foreach($permissions as $permission)
                                <input type="checkbox" id="{{$permission->name}}" name="permissions[]" value="{{$permission->name}}">
                                <label for="{{$permission->name}}">{{$permission->name}}</label><br>
                            @endforeach
                                @error('permissions')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@endsection
