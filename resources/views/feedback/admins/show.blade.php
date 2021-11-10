@extends('feedback.layouts.feedback')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Admin {{$admin->name}}</h1>
@stop

@section('content')


        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{route('feedback.admins.index')}}">Manage Admins</a>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <label>Admin Name</label>
                <p><b>{{$admin->name}}</b></p> <hr>
                <label>Admin Email</label>
                <p><b>{{$admin->email}}</b></p> <hr>
                <label>Admin Role</label>
                <p><b>@if (isset($admin->roles))
                        @foreach($admin->roles as $role)
                        {{$role->name }}
                        @endforeach
                        @endif
                    </b></p> <hr>
                <div class="d-flex ">
                    @can('Admin-edit')
                    <a href="{{ route('feedback.admins.edit',$admin->id) }}" class="btn btn-info o">edit</a>
                    @endcan
                        @can('Admin-delete')
                    <form class="ml-5" action="{{route('feedback.admins.destroy',$admin->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger" value="delete">
                    </form>
                        @endcan
                </div>


            </div>
        </div>

@endsection

