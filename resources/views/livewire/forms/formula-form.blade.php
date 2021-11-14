<div>
    <h1>{{$title}} Formula</h1>
    <a href="{{route('formulas.index')}}">Manage Formulas</a>
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
                    <div class="col-md-10">
                        <select  wire:model.select="category_id" class="custom-select-md  w-100">
                            <option value="">select category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-2">
                        <label for="code" class=" col-form-label text-md-right">Kg</label>
                        <input type="checkbox" wire:model="g">
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
                                        @forelse($searchCategory as $cate)
                                            <a href="#" wire:click.prevent="add({{$cate->id}})" class="list-group-item text-decoration-none" >
                                                <div class="">{{$cate->name}}</div>
                                                @forelse($cate->elements as $elem)
                                                <small class="">{{$elem->name}}</small>
                                                @empty
                                                        Has no elements
                                                @endforelse
                                            </a>
                                        @empty
                                            <div class="list-group-item">
                                                no Category found
                                            </div>
                                        @endforelse
                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    @foreach($activeQategories as $index => $activeQategory)

                        <div class="row form-group">
                            <div class="col-lg-12 col-xl-6">
                              <strong>{{ \App\Models\Category::find($activeQategory['category'])?->name }}</strong>
                            </div>
                            <div class="col-lg-12 col-xl-6 row">
                                <div class="col-4  ">
                                    grams
                                    <input type="number" step=".01" class="form-control" @if(!$g) disabled @endif  wire:model.lazy="activeQategories.{{$index}}.g"  >
                                </div>

                                <div class="col-4 ">
                                    percent
                                    <input type="number" step=".01" class="form-control"  @if($g) disabled @endif   wire:model.lazy="activeQategories.{{$index}}.per" >
                                </div>

                                <div class="col-4">
                                    <button class="btn btn-danger" wire:click.prevent="removeProduct({{$index}})">delete</button>
                                </div>

                            </div>
                            @error('activeQategories.'.$index.'.g')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                            @error('activeQategories.'.$index.'.per')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    @endforeach
                    @if($errors->has('activeQategories'))
                        <span class="text-danger">{{ $errors->first('activeQategories') }}</span>
                    @endif
                </div>
            </div>




        {{--        <x-input.select wire:model="Element" prettyname="modelprettyname" :options="$elements->pluck('name', 'id')->toArray()" selected="('Element')"/>--}}
        <h2>{{ number_format($total,2) }} @if($g) g @else % @endif</h2>

        <div class="form-group row mb-0">

            <div class="col-md-6 ml-auto">
                <button type="submit" wire:click="save" class="btn btn-{{$color}}">
                    {{ $button}}
                </button>
            </div>
            <div class="col-md-6">
                <div class="btn btn-info text-white" wire:click.prevent="filler">
                    fill
                </div>
            </div>
        </div>
    </form>
</div>





