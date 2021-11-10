@extends('feedback.layouts.feedback')

@section('content_header')
    <h1>All Admins</h1>
@stop

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('admin-invite')
                    <a href="{{route('admin.invite')}}" class="btn btn-success">Invite Admin</a>
                 @endcan
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

             <table class="table ">
                 <thead>
                 <tr>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Active</th>
                     <th>Join At</th>
                 </tr>
                 </thead>
                 <tbody>
                 @foreach($admins as $admin)
                 <tr>
                    <td><a href="{{route('feedback.admins.show',$admin->id)}}">{{$admin->name}}</a> </td>
                     <td>{{$admin->email}}</td>
                     <td>{{$admin->active}}</td>
                     <td>{{$admin->created_at->diffForHumans()}}</td>
                 </tr>
                 @endforeach
                 </tbody>
             </table>
            </div>
        </div>



@endsection


