<div>
    <h2>{{$title}} Element</h2>
    <form method="POST"  action="#" wire:submit.prevent="save" >
        @csrf

        <div class="form-group row">
            <div class="col-md-6">
                <label for="name" class=" col-form-label text-md-right">Name</label>
                <input  type="text" class="form-control @error('name') is-invalid @enderror" wire:model.lazy="name" name="name" value="{{ old('name') }}"  >
                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="code" class=" col-form-label text-md-right">Code</label>
                <input  type="text" class="form-control @error('code') is-invalid @enderror" wire:model.lazy="code" name="code" value="{{ old('code') }}"  >
                @error('code')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="category_id" class=" col-form-label text-md-right">Category</label>
                <select  class="form-control " wire:model.lazy="category_id" >
                    <option value="">select Category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')

                        <strong>{{ $message }}</strong>

                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 ">
                <button type="submit" class="btn btn-{{$color}}">
                    {{ $button }}
                </button>
            </div>
        </div>
    </form>
</div>
