@extends('feedback.layouts.feedback')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tenant {{$tenant->id}}</h1>
@stop

@section('content')


        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{route('feedback.tenants.index')}}">Manage Tenants</a>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif <br>
                <label>Tenant Name</label>
                <p><b>{{$tenant->id}}</b></p> <hr>
                <label>Tenant Domains</label>
                <p><b> @foreach($tenant->domains as $domian)
                            <span class="badge badge-primary">
                                          {{$domian->domain}}
                                     </span>
                        @endforeach</b></p> <hr>
                <div class="d-flex ">

                    <a href="{{ route('feedback.tenants.edit',$tenant->id) }}" class="btn btn-info o">edit</a>


                    <form class="ml-5" action="{{route('feedback.tenants.destroy',$tenant->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger" value="delete">
                    </form>

                </div>


            </div>
        </div>

@endsection

