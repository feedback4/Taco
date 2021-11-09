@extends('feedback.layouts.feedback')

@section('content_header')
    <h1>All Tenants</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                    <a href="{{route('feedback.tenants.create')}}" class="btn btn-success">Create Tenant</a>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <table class="table table-hover">

                        <thead>

                        <th>Tenant</th>

                        <th>Domain</th>


                        <th>Created at</th>
                        <th>Actions</th>
                        </thead>

                        <tbody>

                        @foreach($tenants as $tenant)

                            <tr>
                                <td><a href="{{ route('feedback.tenants.show',$tenant->id) }}"> {{$tenant->id}} </a></td>
                                <td>
                                    @foreach($tenant->domains as $domian)
                                     <span class="badge badge-primary">
                                          {{$domian->domain}}
                                     </span>
                                    @endforeach
                                </td>
                                <td>{{$tenant->created_at}} </td>
                                    <td>
                                        <div class="d-flex">
{{--                                            <a href="{{ route('feedback.tenants.edit',$tenant->id) }}" class="btn btn-info">edit</a>--}}
                                            <form action="{{route('feedback.tenants.destroy',$tenant->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger" value="delete">
                                            </form>
                                        </div>
                                    </td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>


            </div>
        </div>
    </div>


@endsection


