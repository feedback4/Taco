<div class="row">

    <div class="col-md-8 ">
        <form method="POST" action="{{route('items.store')}}" wire:submit.prevent="save">
            @csrf
            <div class=" row">
                <div class="col-md-4">
                    <label for="formula_id" class=" col-form-label text-md-right">Formula</label>
                    <select class="form-control " wire:model.lazy="formula_id">
                        <option value="">select Formula</option>
                        @foreach($formulas as $form)
                            <option value="{{$form->id}}">{{$form->name}} -- {{$form->category->name}}</option>
                        @endforeach
                    </select>
                    @error('formula_id' )

                    <span class="text-danger">{{ $message }}</span>

                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="amount" class=" col-form-label text-md-right">Amount</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                           wire:model.lazy="amount" name="amount" value="{{ old('amount') }}">
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="unit" class=" col-form-label text-md-right">unit</label>
                    <select wire:model="unit" class="form-control @error('unit') is-invalid @enderror">
                        <option value="">select Unit</option>
                        @foreach($units as $uni)
                            <option value="{{$uni}}">{{$uni}}</option>
                        @endforeach
                    </select>
                    @error('unit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-2 mt-auto">
                    <button type="submit" wire:click.prevent="generate" class="btn btn-secondary">
                        Generate
                    </button>
                </div>
            </div>
            @if($formula)
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hove table-responsive-md">
                            @foreach($formula->elements as $index => $element)
                                <tr>
                                    <th>{{$element->category->name}}</th>
                                    <th> {{ ($element->pivot->amount * $amount ) / 100 }} kg</th>
                                    <th> Inventory </th>
                                    <th> Expire Date </th>
                                    <th> @if(isset($proElement[$index]))  {{ array_sum($proElement[$index]) }} @else 0 @endif kg</th>
                                </tr>
                                @forelse( App\Models\Item::whereHas('category',fn($q)=> $q->where('categories.id',$element->category->id))->with('element','inventory')->get() as $item)
                                    <tr>
                                        <td> {{$item->element->name}}</td>
                                        <td>{{$item->amount}} kg</td>
                                        <td>{{$item->inventory->name}}</td>
                                        <td>{{$item->expire_at->format('Y-m-d')}}</td>
                                        <td><input type="number" class="form-control" wire:model="invElement.{{$index}}.{{$item->id}}" min="0" max="{{$item->amount}}"></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger">There is no Elements of this category in inventory</td>
                                    </tr>
                                @endforelse
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        </form>
    </div>
    <div class="col-md-4">
        <h3>Total {{$total}} %</h3>
        @if($formula)
            <table class="table table-hove table-responsive-md">
                <tr>
                    <th>Formula</th>
                    <td>{{$formula->name}}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>{{$amount}} {{ $unit }} </td>
                </tr>
                <tr>
                    <th>Elements</th>
                </tr>
                <tr>
                @foreach($formula->elements as $element)
                    <tr>
                        <th>{{$element->category->name}}</th>
                        <td>{{$element->pivot->amount}} % </td>
                    </tr>
                @endforeach
                </tr>
            </table>
        @endif
        <button type="submit" class="btn btn-dark w-100">
            Go
        </button>

    </div>

</div>
