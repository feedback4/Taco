<div>
    <h1>{{$title}} Formula</h1>
    <div class="mb-2">
        <a href="{{route('formulas.index')}}" class="btn btn-outline-primary">Manage Formulas</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form method="POST" action="#" wire:submit.prevent="save" >
        @csrf
        <input type="submit" wire:click.prevent="" class="d-none">
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
                        <select  wire:model.select="category_id" class="form-control  w-100">
                            <option value="">select category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-2 d-flex">
                        <b>%</b>
                        <div class="custom-control custom-switch">
                            <input type="checkbox"  id="customSwitch1" class="custom-control-input"  wire:model="g" >
                            <label class="custom-control-label" for="customSwitch1"><b>kg</b></label>
                        </div>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-md-7">
                        <select  wire:model.select="compound" class="form-control w-100">
                            <option value="">select Compound</option>
                            @foreach($compounds as $compound)
                                <option value="{{$compound->id}}">{{$compound->name}}</option>
                            @endforeach
                        </select>
                        @error('filler')
                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <input type="number" wire:model.lazy="percent" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button wire:click.prevent="addCompound" class="btn btn-danger">Add</button>
                    </div>
                    @error('compound')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                    @error('percent')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <select  wire:model.select="filler" class="form-control w-100">
                            <option value="">select Filler</option>
                            @foreach($fillers as $filler)
                                <option value="{{$filler->id}}">{{$filler->name}}</option>
                            @endforeach
                        </select>
                        @error('filler')
                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <div class="btn btn-info text-white" wire:click.prevent="filler">
                            fill
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-md-12">
                        <div class="form-group sidebar-search-open w-100">
                            <div class="input-group">
                                <input class="form-control " wire:model.debounce.200ms="query" type="search"
                                       placeholder="Search Elements..."
                                       aria-label="Search">

                            </div>
                            <div class="list-group">
                                <div class="list-group-item" wire:loading  wire:target="query">
                                    Loading Elements...
                                </div>
                            </div>

                            @if(!empty($query))

                                    <div class="list-group" wire:loading.remove>
                                        @forelse($searchElements as $elem)
                                            <a href="#" wire:click.prevent="addElement({{$elem->id}})" class="list-group-item text-decoration-none" >
                                                <div class="">{{$elem->name}}</div>
                                                <small class="">{{$elem->category->name}}</small>
                                            </a>
                                        @empty
                                            <div class="list-group-item" >
                                                No Elements Found
                                            </div>
                                        @endforelse
                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    @foreach($activeElements as $index => $activeElement)

                        <div class="row form-group" >
                            <div class="col-lg-12 col-xl-6">
                              <strong>{{ \App\Models\Element::find($activeElement['element_id'])?->name }}</strong>
                            </div>
                            <div class="col-lg-12 col-xl-6 row" >
                                <div class="col-4  ">
                                    grams
                                    <input type="number" step=".01" wire:keydown.enter="enter" class="form-control" @if(!$g) disabled @endif  wire:model.lazy="activeElements.{{$index}}.g"  >
                                </div>

                                <div class="col-4 ">
                                    percent
                                    <input type="number" step=".01" wire:keydown.enter="enter" class="form-control"  @if($g) disabled @endif   wire:model.lazy="activeElements.{{$index}}.per" >
                                </div>

                                <div class="col-4">
                                    <button class="btn btn-danger"  wire:keydown.enter="enter" wire:click.prevent="removeElement({{$index}})">delete</button>
                                </div>

                            </div>
                            @error('activeElements.'.$index.'.g')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                            @error('activeElements.'.$index.'.per')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    @endforeach
                    @if($errors->has('activeElements'))
                        <span class="text-danger">{{ $errors->first('activeElements') }}</span>
                    @endif
                </div>
            </div>




        {{--        <x-input.select wire:model="Element" prettyname="modelprettyname" :options="$elements->pluck('name', 'id')->toArray()" selected="('Element')"/>--}}
        <h2>{{ number_format($total,2) }} @if($g) g @else % @endif</h2>

        <div class="form-group row mb-0">

            <div class="col-md-6 ml-auto">
                <button  wire:click.prevent="save" class="btn btn-{{$color}}">
                    {{ $button}}
                </button>
            </div>

        </div>
    </form>
</div>





