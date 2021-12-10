@extends('layouts.admin')

@section('content_header')

   <h1>Production  {{$order->number }}  </h1>
<a href="{{route('production.index')}}" class="btn btn-primary">Production</a>
@stop

@section('content')


    <div class="row ">
        <div class="col-md-6">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <h3>Formula <a href="{{route('formulas.formulas.show',$order->formula->id)}}">{{$order->formula->code}}</a></h3>
                <label>Order Date</label>
                <p><b>{{$order->created_at->format('d/m/Y')}}</b></p> <hr>
            <label>Order Amount</label>
            <p><b>{{$order->amount}}</b></p> <hr>
            <label>Order Times</label>
            <p><b>{{$order->times}}</b></p> <hr>
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
                @foreach($order->formula->elements as $element)
                    <tr>
                        <td>  <a href="{{route('formulas.elements.show',$element->id)}}"> {{$element->name}} -- {{$element->code}}</a>  </td>
                        <td><a href="{{route('formulas.categories.show',$element->category->id)}}">{{$element->category->name}}</a></td>
                        <td> <b>{{$element->pivot->amount *10 }}</b> g </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            </p>  <hr>

{{--            <div class="d-flex ">--}}
{{--                @can('element-edit')--}}
{{--                    <a href="{{ route('formulas.edit',$formula->id) }}" class="btn btn-info o">edit</a>--}}
{{--                @endcan--}}
{{--                @can('element-delete')--}}
{{--                    <form class="ml-5" action="{{route('formulas.destroy',$formula->id) }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <input type="submit" class="btn btn-danger" value="delete">--}}
{{--                    </form>--}}
{{--                @endcan--}}
{{--            </div>--}}


        </div>
    </div>

@endsection

