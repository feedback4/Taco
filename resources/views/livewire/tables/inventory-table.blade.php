<div class="container-fluid ">

        <div class="row my-3 d-flex">
            <div class="col-md-6">
                <input type="search" wire:model.debounce.400ms="search" class="form-control" placeholder="search in names">
            </div>
            <div class="col-xs-2">
                <select wire:model="orderBy" class="form-control-sm">
                    <option>Id</option>
                    <option>Amount</option>
                    <option>Expire</option>
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
            <table class="table table-hover">
                <thead>
                <th class="border  py-2">ID</th>
                <th class="border  py-2">Element</th>
                <th class="border  py-2">Amount</th>
                <th class="border  py-2">Expire</th>
                <th class="border  py-2">Category</th>
{{--                <th class="border  py-2">Edit</th>--}}
{{--                <th class="border  py-2">Delete</th>--}}
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="border  py-2">{{$item->id}} </td>
                        <td class="border  py-2"><a href="{{route('elements.show',$item->element->id)}}">{{$item->element->name}}</a></td>
                        <td class="border  py-2">{{$item->amount}} {{$item->unit}}</td>
                        <td class="border  py-2">{{$item->expire_at->diffForHumans()}}</td>
                        <td class="border  py-2">
                            @if($item->element)
                                {{$item->element->category->name}}
                            @else
                                no category
                            @endif
                        </td>
{{--                        @can('element-edit')--}}
{{--                            <td>--}}
{{--                                <button wire:click="edit({{ $item->id }})" class="btn btn-primary">Edit</button>--}}
{{--                            </td>--}}

{{--                        @endcan--}}
{{--                        @can('element-delete')--}}
{{--                            <td>--}}
{{--                                <button wire:click="delete({{ $item->id }})" class="btn btn-danger">Delete</button>--}}
{{--                            </td>--}}
{{--                        @endcan--}}
                    </tr>
                @empty
                    <tr>
                        <th>
                            no result found
                        </th>

                    </tr>

                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $items->links() }}
        </div>
        <div class="row">
            <div class="btn btn-danger" wire:click="export">
                Export
            </div>
        </div>

</div>
