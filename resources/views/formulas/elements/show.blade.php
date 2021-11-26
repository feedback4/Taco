@extends('layouts.admin')

@section('content_header')
    <h1>Element {{$element->name}}</h1>
@stop

@section('content')


        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mb-2">
                    <a href="{{route('elements.index')}}" class="btn btn-outline-primary">Manage Elements</a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <label>Element Name</label>
                <p><b>{{$element->name}}</b></p> <hr>
                <label>Element Code</label>
                <p><b>{{$element->code}}</b></p> <hr>
                <label>Element Category</label>
                <p><b><a href="{{route('categories.show',$element->category->id)}}">{{$element->category->name}}</a></b></p> <hr>
                <label>Element formulas</label>
                <p>
                <table class="table ">
                    <thead>
                    <tr>
                        <th>Formula</th>
                        <th>Category</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($element->formulas as $formula)
                        <tr>
                            <td>  <a href="{{route('formulas.show',$formula->id)}}"> {{$formula->name}}</a>  </td>
{{--                            <td><a href="{{route('categories.show',$formula->category->id)}}">{{$formula->category->name}}</a></td>--}}
                            <td>{{$formula->pivot->amount }} %</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

                </p> <hr>
            </div>
        </div>

@endsection

