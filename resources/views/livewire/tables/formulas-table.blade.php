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
                    <option>code</option>
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
            <table class="table table-hover table-responsive-sm ">
                <thead>
                <th class="border  py-2">ID</th>
                <th class="border  py-2">Name</th>
                <th class="border  py-2">Code</th>
                <th class="border  py-2">Category</th>
                <th class="border  py-2">Edit</th>
                <th class="border  py-2">Delete</th>
                </thead>
                <tbody>
                @foreach($formulas as $formula)
                    <tr>
                        <td class="border  py-2">{{$formula->id}} </td>
                        <td class="border  py-2"><a href="{{route('formulas.show',$formula->id)}}">{{$formula->name}}</a></td>
                        <td class="border  py-2">{{$formula->code}} </td>
                        <td class="border  py-2">
                            @if($formula->category)
                                {{$formula->category->name}}
                            @else
                                no category
                            @endif
                        </td>
                        @can('formula-edit')
                            <td>
                                <a href="{{route('formulas.edit',$formula->id)}}" class="btn btn-primary">Edit</a>
                            </td>

                        @endcan
                        @can('formula-delete')
                            <td>
                                <form action="{{route('formulas.destroy',$formula->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $formulas->links() }}
        </div>

    </div>


</div>






