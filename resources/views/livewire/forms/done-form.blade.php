<div class="col-md-12 ">

    <h4>{{$productionOrder->number}} : {{$productionOrder->amount}} kg of <a
            href="{{route('formulas.formulas.show',$productionOrder->formula->id)}}">{{$productionOrder->formula->code}}</a>
    </h4>

    <form action="">

        <div class="form-group row">
            <div class="col-md-8 ">
                <div class="row">
                    <div class="col-md-3 ">
                        <label for="quantity">quantity</label>
                        <input type="number" wire:model.lazy="quantity" class="form-control">
                        @error('quantity')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 ">
                        <label for="price">price</label>
                        <input type="number" wire:model.lazy="price" class="form-control">
                        @error('price')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 ">
                        <label for="description">Description</label>
                        <input type="text" wire:model.lazy="description" class="form-control">
                        @error('description')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="working_hours">Working Hours</label>
                        <input type="number" wire:model.lazy="working_hours" class="form-control">
                        @error('working_hours')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="workers">Worker</label>
                        <input type="number" wire:model.lazy="workers" class="form-control">
                        @error('workers')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="col-md-4 mt-2">
                <h3>Product Details </h3>
                <table class="table">
                    <tr>
                        <th>Product</th>
                        <td>{{$productionOrder->formula->product->name}}
                            -- {{$productionOrder->formula->product->code}}</td>
                    </tr>
                    <tr>
                        <th>Expected</th>
                        <td>{{ number_format($expected_amount,2) }} kg <small>with 5% loses</small></td>
{{--                        <td>{{number_format($expected_price,2) }} EGP </td>--}}
                    </tr>
                    <tr>
                        <th>Materials Cost</th>
                        <td>{{ $cost }} {{setting('currency')}} </td>
                    </tr>

                    <tr>
                        <th>Hours Cost</th>
                        <td>{{ $hourCost }} {{setting('currency')}}  <small>{{$perHour}} eg per hour</small></td>
                    </tr>


                    <tr>
                        <th>Loses</th>
                        <td>{{ number_format($loses,2) }} %
                            @if($loses > 5 )
                                <i class='bx bx-error bx-xs text-danger mt-auto'></i>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Total Cost</th>
                        <td> <b>{{ $totalCost }}</b> {{setting('currency')}}</td>
                    </tr>

                    <tr>
                        <th>Cost Per Unit</th>
                        <td>
                            {{ number_format($cost_per_unit , 2) }} {{setting('currency')}}
                        @if($cost_per_unit > $expected_price)
                                <i class='bx bx-error bx-xs text-danger mt-auto'></i>
                            @endif
                        </td>
                    </tr>



                </table>
                <button type="submit" wire:click.prevent="finish" class="btn btn-dark w-100 h4">
                    Finish
                </button>

            </div>
        </div>
    </form>
</div>
