<div>
    <form method="POST" action="#" wire:submit.prevent="save">
        @csrf

        <div class="form-group row">
            <div class="col-md-6">
                <label for="name" class=" col-form-label text-md-right">{{ __('Name') }}</label>
                <input wire:model.lazy="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="code" class=" col-form-label text-md-right">code</label>
                <input wire:model.lazy="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}"  autocomplete="code" >

                @error('code')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <select  wire:model="category_id" class="form-select w-100"  >
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
            <div class="col-md-10">
                <select  wire:model="element[]" class="form-select w-100"   multiple >
                    <option value="">select element</option>
                    @foreach($elements as $element)
                        <option value="element.{{$element->id}}">{{$element->name}}--{{$element->category->name}}</option>
                    @endforeach
                </select>
                @error('element')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-2">
                <a href="#" class="btn btn-primary"  wire:click.prevent="add" >add</a>
            </div>
        </div>
        @foreach($activeElements as $element)
            <div class="row form-group">
                <div class="col-md-8">
                    {{$element}}
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control"   wire:model="element.{{$element}}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger" wire:click.prevent="delete($element)">delete</button>
                </div>
            </div>
        @endforeach

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
