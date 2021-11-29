@extends('layouts.admin')

@section('content_header')
    <h1>All Users</h1>
@stop

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">

                    <a href="{{route('hr.users.create')}}" class="btn btn-success">Create User</a>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <livewire:tables.users-table />
            </div>
        </div>



@endsection


