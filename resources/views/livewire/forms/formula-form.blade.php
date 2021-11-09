<div>
    <form method="POST" action="#" wire:submit.prevent="save">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name" class=" col-form-label text-md-right">{{ __('Name') }}</label>
                        <input wire:model.lazy="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="code" class=" col-form-label text-md-right">code</label>
                        <input wire:model.lazy="code" type="text"
                               class="form-control @error('code') is-invalid @enderror"
                               name="code" value="{{ old('code') }}" autocomplete="code">

                        @error('code')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <select wire:model.select="category_id" class="form-select select2 w-100">
                            <option value="">select category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <div class="form-group sidebar-search-open w-100">
                            <div class="input-group">
                                <input class="form-control " wire:model="query" type="search"
                                       placeholder="Search Elements..."
                                       aria-label="Search">

                            </div>
                            @if(!empty($query))
                                    <div class="list-group">
                                        @forelse($searchElements as $k=> $elem)
                                            <a href="#" wire:click.prevent="add({{$elem->id}})" class="list-group-item">
                                                <div class="">{{$elem->name}}</div>
                                                <small class="">{{$elem->category->name}}</small>
                                            </a>

                                            @if ($k == 5)
                                                @break
                                            @endif
                                        @empty
                                            <div class="list-group-item">
                                                no element found
                                            </div>
                                        @endforelse
                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    @foreach($activeElements as $activeElement)
                        <div class="row form-group">
                            <div class="col-lg-12 col-xl-6">
                              <strong>{{ \App\Models\Element::find($activeElement)->name }}</strong>
                            </div>
                            <div class="col-lg-12 col-xl-6 row">
                                <div class="col-4  ">
                                percent
                                </div>
                                <div class="col-4 ">
                                    <input type="number" step=".25" class="form-control" wire:model.lazy="selectedElements.{{$activeElement}}">
                                </div>

                                <div class="col-4  ">
                                    <button class="btn btn-danger" wire:click.prevent="delete({{$activeElement}})">delete</button>
                                </div>
                            </div>
                            @error('selectedElements'.$activeElement)
                            {{$message}}
                            @enderror
                        </div>
                    @endforeach
                    @if($errors->has('selectedElements'))
                        <span class="text-danger">{{ $errors->first('selectedElements') }}</span>
                    @endif
                </div>
            </div>

            {{--            <div class="col-md-10">--}}
            {{--                <select wire:model="element" class="form-select select-2 w-100">--}}
            {{--                    <option value="">select element</option>--}}
            {{--                    @foreach($elements as $elem)--}}
            {{--                        <option value="{{$elem->id}}">{{$elem->name}}--}}
            {{--                            --{{$elem->category->name}}</option>--}}
            {{--                    @endforeach--}}
            {{--                </select>--}}
            {{--                @error('element')--}}
            {{--                <span class="invalid-feedback" role="alert">--}}
            {{--                        <strong>{{ $message }}</strong>--}}
            {{--                    </span>--}}
            {{--                @enderror--}}
            {{--            </div>--}}
            {{--            <div class="col-md-2">--}}
            {{--                <a href="#" class="btn btn-primary" wire:click.prevent="add({{$element}})">add</a>--}}
            {{--            </div>--}}
        </div>

        {{--        <x-input.select wire:model="Element" prettyname="modelprettyname" :options="$elements->pluck('name', 'id')->toArray()" selected="('Element')"/>--}}

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" wire:click="save" class="btn btn-success">
                    {{ __('Create') }}
                </button>
            </div>
        </div>
    </form>
</div>





