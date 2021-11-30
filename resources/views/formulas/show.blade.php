@extends('layouts.admin')

@section('content_header')
    <div class="">    <h1>Formula {{$formula->name}}</h1></div>

    <div class="">       <a href="{{route('formulas.index')}}" class="btn btn-outline-primary">Manage Formulas</a></div>

@stop

@section('content')


    <div class="row ">
        <div class="col-md-6">


            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <label>Formula Name</label>
            <p><b>{{$formula->name}}</b></p> <hr>
            <label>Formula Code</label>
            <p><b>{{$formula->code}}</b></p> <hr>

            <label>Formula Category</label>
            <p><b>
                  @if($formula->category)  <a href="{{route('categories.show',$formula->category->id)}}">{{$formula->category->name}}</a> @else No Category @endif
                </b></p> <hr>
            <label>Formula elements</label>
            <p>
                <table class="table ">
                    <thead>
                        <tr>
                          <th>Element</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($formula->elements as $element)
                    <tr>
                        <td>  <a href="{{route('elements.show',$element->id)}}"> {{$element->name}} -- {{$element->code}}</a>  </td>
                        <td><a href="{{route('categories.show',$element->category->id)}}">{{$element->category->name}}</a></td>
                        <td> <b>{{$element->pivot->amount *10 }}</b> g </td>
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

