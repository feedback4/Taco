@extends('layouts.admin')

@section('content_header')
    <h1>Element {{$element->name}}</h1>
@stop

@section('content')


        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{route('elements.index')}}">Manage Elements</a>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <label>User Name</label>
                <p><b>{{$element->name}}</b></p> <hr>
                <label>User Email</label>
                <p><b>{{$element->email}}</b></p> <hr>


                <div class="d-flex ">
                    @can('element-edit')
                    <a href="{{ route('elements.edit',$element->id) }}" class="btn btn-info o">edit</a>
                    @endcan
                    @can('element-delete')
                    <form class="ml-5" action="{{route('elements.destroy',$element->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger" value="delete">
                    </form>
                        @endcan
                </div>


            </div>
        </div>

@endsection

