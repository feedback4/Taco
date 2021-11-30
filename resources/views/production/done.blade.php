@extends('layouts.admin')

@section('content_header')
    <h1>Finish Production</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 ">

                <h4>{{$productionOrder->amount}} kg  of <a href="{{route('formulas.formulas.show',$productionOrder->formula->id)}}">{{$productionOrder->formula->code}}</a></h4>

            <form action="" >


                <div class="form-group row">
                    <div class="col-md-2 col-6">
                        <label for="quantity">quantity</label>
                        <input type="number" name="quantity" class="form-control">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="price">price</label>
                        <input type="number" name="price" class="form-control">
                    </div>
                    <div class="col-md-4 ">
                        <label for="description">Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <tr>
                                <th>Product</th>
                                <td>{{$productionOrder->formula->product->name}} -- {{$productionOrder->formula->product->code}}</td>
                            </tr>
                            <tr>
                                <th>Texture</th>
                                <td>{{$productionOrder->formula->product->texture}}</td>
                            </tr>
                            <tr>
                                <th>Gloss</th>
                                <td>{{$productionOrder->formula->product->gloss}}</td>
                            </tr>
                            <tr>
                                <th>Color Family</th>
                                <td>{{$productionOrder->formula->product->color_family}}</td>
                            </tr>
                            <tr>
                                <th>Expected</th>
                                <td>{{$productionOrder->amount - ($productionOrder->amount  * .05)}} kg <small>with 5% losses</small></td>
                            </tr>

                        </table>

                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
