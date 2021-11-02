<div>
    <div class="container-fluid ">
        <div class="row my-3 d-flex">
            <div class="col-md-6">
                <input type="search" wire:model.debounce.400ms="search" class="form-control" placeholder="search in names">
            </div>
            <div class="col-xs-2">
                <select wire:model="orderBy" class="form-control-sm">
                    <option>Id</option>
                    <option>Name</option>
                    <option>unit</option>
                </select>
            </div>
            <div class="col-xs-2">
                <select wire:model="orderAsc" class="custom-select-sm border">
                    <option value="1">Asc</option>
                    <option value="0">Desc</option>
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
                <th class="border  py-2">Name</th>
                <th class="border  py-2">Unit</th>
                <th class="border  py-2">Category</th>
                <th class="border  py-2">Edit</th>
                <th class="border  py-2">Delete</th>
                </thead>
                <tbody>
                @foreach($elements as $element)
                    <tr>
                        <td class="border  py-2">{{$element->id}} </td>
                        <td class="border  py-2"><a href="{{route('elements.show',$element->id)}}">{{$element->name}}</a></td>
                        <td class="border  py-2">{{$element->unit}} </td>
                        <td class="border  py-2">
                            @if($element->category)
                                {{$element->category->name}}
                            @else
                                no category
                            @endif
                        </td>
                        @can('element-edit')
                            <td>
                                <button wire:click="edit({{ $element->id }})" class="btn btn-primary">Edit</button>
                            </td>

                        @endcan
                        @can('element-delete')
                            <td>
                                <button wire:click="delete({{ $element->id }})" class="btn btn-danger">Delete</button>
                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $elements->links() }}
        </div>

    </div>


</div>






