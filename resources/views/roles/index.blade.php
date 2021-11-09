@extends('layouts.admin')

@section('content_header')
    <h1>All Roles</h1>
@stop
@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('role-create')
                    <a href="{{route('roles.create')}}" class="btn btn-success">Create Role</a>
                @endcan
                @can('permissions')
                    <a href="{{route('roles.permissions')}}" class="btn btn-outline-primary">permissions</a>
                @endcan

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="table table-hover">

                    <thead>

                    <th>Role</th>

                    <th>Role ID</th>


                    <th>Created at</th>

                    </thead>

                    <tbody>

                    @foreach($roles as $role)

                        <tr>

                            <td><a href="{{ route('roles.show',$role->id) }}"> {{$role->name}} </a></td>

                            <td>{{$role->id}} </td>


                            <td>{{$role->created_at}} </td>
                            @can('role-edit')
                                <td><a href="{{ route('roles.edit',$role->id) }}" class="btn btn-info">edit</a></td>
                            @endcan
                            @can('role-delete')
                                <td>
                                    <form action="{{route('roles.destroy',$role->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger" value="delete">
                                    </form>
                                </td>
                            @endcan

                        </tr>
                    @endforeach

                    </tbody>

                </table>
                {{ $roles->links() }}
            </div>
        </div>

@endsection

