<div>
    <div class="container-fluid ">
{{--        <div class="row my-3 d-flex">--}}
{{--            <div class="col-md-6">--}}
{{--                <input type="search" wire:model.debounce.400ms="search" class="form-control" placeholder="search in names">--}}
{{--            </div>--}}
{{--            <div class="col-xs-2">--}}
{{--                <select wire:model="orderBy" class="form-control-sm">--}}
{{--                    <option>Id</option>--}}
{{--                    <option>Name</option>--}}
{{--                    <option>Code</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="col-xs-2">--}}
{{--                <select wire:model="orderDesc" class="custom-select-sm border">--}}
{{--                    <option value="1">Desc</option>--}}
{{--                    <option value="0">Asc</option>--}}

{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="col-xs-2">--}}
{{--                <select wire:model="perPage" class="form-control-sm">--}}
{{--                    <option>5</option>--}}
{{--                    <option>10</option>--}}
{{--                    <option>25</option>--}}
{{--                    <option>50</option>--}}
{{--                    <option>100</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
        <h3>All Compounds</h3>
        <div class="row">
            <table class="table table-hover table-responsive-sm ">
                <thead>
                <th class="border  py-2">ID</th>
                <th class="border  py-2">Name</th>
                <th class="border  py-2">Code</th>
                <th class="border  py-2">Elements</th>
                <th class="border  py-2">Edit</th>
                <th class="border  py-2">Delete</th>
                </thead>
                <tbody>
                @foreach($compounds as $compound)
                    <tr>
                        <td class="border  py-2">{{$compound->id}} </td>
                        <td class="border  py-2">{{$compound->name}}</td>
                        <td class="border  py-2">{{$compound->code}} </td>
                        <td class="border  py-2">
                            @foreach($compound->elements as $element)
                                <a href="{{route('elements.show',$element->id)}}"><span class="badge badge-primary">{{$element->name}}</span></a>
                            @endforeach
                        </td>
                        @can('element-edit')
                            <td>
                                <button wire:click="edit({{ $compound->id }})" class="btn btn-primary">Edit</button>
                            </td>

                        @endcan
                        @can('element-delete')
                            <td>
                                <button wire:click="delete({{ $compound->id }})" class="btn btn-danger">Delete</button>
                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

{{--        <div class="d-flex justify-content-center">--}}
{{--            {{ $compounds->links() }}--}}
{{--        </div>--}}

    </div>


</div>






