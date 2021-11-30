@extends('layouts.admin')

@section('content_header')
    <h1>Category {{$category->name}}</h1>
    <div class="">  <a href="{{route('formulas.categories.index')}}" class="btn btn-outline-primary ">Manage Categories</a></div>
@stop

@section('content')


    <div class="row justify-content-center">
        <div class="col-md-12">


            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <label>Category Name</label>
            <p><b>{{$category->name}}</b></p> <hr>
            <label>Category type</label>
            <p><b>{{$category->type}}</b></p> <hr>
            @if($category->parent)
            <label>Category Parent</label>
            <p><b><a href="{{route('formulas.categories.show',$category->parent->id)}}"> {{$category->parent->name ?? 'no parent'}}</a></b></p> <hr>
            @endif
            <label>Category Children</label>
            <p><b>
                    @forelse($category->children as $child)
                        <span class="mx-1"><a href="{{route('formulas.categories.show',$child->id)}}">{{$child->name}}</a></span>
                    @empty
                        No Children yet
                    @endforelse</b></p> <hr>

            <label>Category Formulas</label>
            <div class="">
                @forelse($category->formulas as $formula)
                    <span class="mx-1"><a href="{{route('formulas.formulas.show',$formula->id)}}">{{$formula->name}}</a></span>
                @empty
                   <b>No formula yet</b>

                @endforelse

            </div>      <hr>
            <label>Category Elements</label>
            <div class="">
                @forelse($category->elements as $element)
                    <span class="mx-1"><a href="{{route('formulas.elements.show',$element->id)}}">{{$element->name}}</a></span>
                @empty
                    No formula yet
                @endforelse

            </div>


        </div>
    </div>

@endsection

