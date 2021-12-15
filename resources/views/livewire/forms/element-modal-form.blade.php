<div>
    <div type="button" class="btn btn-sm btn-success " data-toggle="modal" wire:click.pervent="open"
         data-target="#elementModal">
        Create Element
    </div>

    <div wire:ignore.self class="modal fade " id="elementModal" tabindex="-1" role="dialog" aria-hidden="true"
         aria-labelledby="elementModalLabel" style="z-index: 1051;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="elementModalLabel">Create Element</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name" class=" col-form-label text-md-right">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       wire:model.lazy="name" autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="code" class=" col-form-label text-md-right">Code</label>
                                <input type="tel" class="form-control @error('code') is-invalid @enderror"
                                       wire:model.lazy="code" autocomplete="code">

                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class=" col-form-label text-md-right">Category</label>
                                <select class="form-control " id="category_id" wire:model.lazy="category_id">
                                    <option value="">select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                                wire:key="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_price" class=" col-form-label text-md-right">Last Price</label>
                                <input type="number" min="0" class="form-control @error('last_price') is-invalid @enderror"
                                       wire:model.lazy="last_price" name="last_price" value="{{ old('last_price') }}">
                                @error('last_price')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <!-- Modal -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click.pervent="close" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" wire:click.pervent="save">Save & Select</button>
                </div>
            </div>
        </div>
    </div>
</div>
