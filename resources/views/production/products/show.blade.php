@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Product {{$product->name}}</h1>
    <a href="{{route('production.products.index')}}">Manage Products</a>
@stop

@section('content')


        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <label>Product Name</label>
                <p><b>{{$product->name}}</b></p> <hr>
                    <label>Product Code</label>
                    <p><b>{{$product->code}}</b></p> <hr>
                    <label>Product Formula</label>
                    <p><b> <a href="{{route('formulas.formulas.show',$product->formula->id)}}">{{$product->formula->name}}</a></b></p> <hr>
                    <label>Product Formula</label>
                    <p><b> <a href="{{route('formulas.categories.show',$product->category->id)}}">{{$product->category->name}}</a></b></p> <hr>
                <label>Product Texture</label>
                <p><b>{{$product->texture}}</b></p> <hr>
                    <label>Product Gloss</label>
                    <p><b>{{$product->gloss}}</b></p> <hr>
                    <label>Product Color Family</label>
                    <p><b>{{$product->color_family}}</b></p> <hr>

                    <label>Product Curing Time</label>
                    <p><b>{{$product->curing_time}}</b></p> <hr>


            </div>
        </div>

@endsection

