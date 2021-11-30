@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Vendor {{$vendor->name}}</h1>
    <a href="{{route('purchases.vendors.indexx')}}">Manage Vendors</a>
@stop

@section('content')


        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <label>Vendor Name</label>
                <p><b>{{$vendor->name}}</b></p> <hr>
                    <label>Vendor Phone</label>
                    <p><b>{{$vendor->phone}}</b></p> <hr>
                <label>Vendor Email</label>
                <p><b>{{$vendor->email}}</b></p> <hr>
                    <label>Vendor Address</label>
                    <p><b>{{$vendor->address}}</b></p> <hr>
                <label>Vendor Role</label>
                <p><b>@if (isset($roles))
                        @foreach($roles as $role)
                        {{$role }}
                        @endforeach
                        @else
                          {{$user->role  }}
                        @endif
                    </b></p> <hr>
                <div class="d-flex ">

                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-info o">edit</a>

                    <form class="ml-5" action="{{route('users.destroy',$user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger" value="delete">
                    </form>

                </div>


            </div>
        </div>

@endsection

