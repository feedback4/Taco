@extends('feedback.layouts.feedback')
@section('content_header')
    <h1>All Permissions</h1>
@stop
@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#permissionModal">Create Field</button>
                @foreach($permissions as $permission)
                    <div class="d-flex w-25">
                        <p class="">{{$permission->name}}</p>
                        <p class="ml-auto"> <form action="{{route('feedback.permission.delete',$permission->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="delete">
                        </form></p>

                    </div>

                @endforeach
            </div>
        </div>




    <!-- Modal -->
    <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new Permissions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('feedback.roles.permissions')}}">
                        @csrf

                        <div class="form-group" >
                            <label for="name">Permission Name</label>
                            <input type="text" name="name" class="form-control" id="fieldName">
                            <small id="formFieldName"></small>
                        </div>
                        @error('name')
                        <strong>{{ $message }}</strong>
                        @enderror

                        <div class="form-group row  ">
                            <div class="col-md-6  ">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
