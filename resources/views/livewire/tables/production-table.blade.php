<div class="container-fluid ">

    <div class="row my-3 d-flex">
        <div class="col-md-6">
            <input type="search" wire:model.debounce.400ms="search" class="form-control" placeholder="search in names">
        </div>
        <div class="col-xs-2">
            <select wire:model="orderBy" class="form-control-sm">
                <option>Id</option>
                <option>Amount</option>
                <option value="created_at">Created</option>
            </select>
        </div>
        <div class="col-xs-2">
            <select wire:model="orderDesc" class="custom-select-sm border">
                <option value="1">Desc</option>
                <option value="0">Asc</option>

            </select>
        </div>
        <div class="col-xs-2">
            <select wire:model="perPage" class="form-control-sm">
                <option>5</option>
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-12" id="accordion">
            @forelse($productionOrders as $k=> $order)
                <div class="card card-danger card-outline">

                        <div class="card-header bg-cyan" data-toggle="collapse" href="#collapse-{{$k}}">
                            <h4 class="card-title w-100">
                                {{$order->formula->name}} <b>{{$order->amount}} kg</b>
                            </h4>
                        </div>

                    <div id="collapse-{{$k}}" class="collapse" data-parent="#accordion">
                        <div class="card-body">

                            @if($order->items)
                                <table class="table table-bordered table-responsive-md">
                                    <thead>
                                    <tr>
                                        <th>Element</th>
                                        <th>Amount</th>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{$item->element->name}}</td>
                                            <td><b>{{ $item->pivot->amount }} </b>kg</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>no Items</p>
                            @endif
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{route('production.print',$order->id)}}" class="btn btn-secondary ">
                                 Print
                                </a>
                                <small>{{$order->created_at->diffForHumans()}}</small>
                            </div>

                        </div>
                    </div>
                </div>

            @empty

                <div class="">no result found</div>



            @endforelse

        </div>

        <div class="d-flex justify-content-center">
            {{ $productionOrders->links() }}
        </div>
    </div>
</div>
