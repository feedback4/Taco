@extends('layouts.admin')

@section('content_header')
    <h1>Formula {{$formula->name}}</h1>
@stop

@section('content')


    <div class="row ">
        <div class="col-md-6">
            <a href="{{route('formulas.index')}}">Manage Formulas</a>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <label>Formula Name</label>
            <p><b>{{$formula->name}}</b></p> <hr>
            <label>Formula Code</label>
            <p><b>{{$formula->code}}</b></p> <hr>
            <label>Formula Categories</label>

            <p>
                <table class="table ">
                    <thead>
                        <tr>
                          <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($formula->categories as $category)
                    <tr>
                        <td>  <a href="{{route('categories.show',$category->id)}}"> {{$category->name}}</a> </td>
                        <td>{{$category->pivot->amount }} @if($g) g @else % @endif</td>
                    </tr>

                @endforeach
                </tbody>
            </table>

             </p> <hr>


            <div class="d-flex ">
                @can('element-edit')
                    <a href="{{ route('formulas.edit',$formula->id) }}" class="btn btn-info o">edit</a>
                @endcan
                @can('element-delete')
                    <form class="ml-5" action="{{route('formulas.destroy',$formula->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger" value="delete">
                    </form>
                @endcan
            </div>


        </div>
    </div>

@endsection

