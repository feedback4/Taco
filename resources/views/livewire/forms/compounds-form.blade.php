<div class="card card-primary  collapsed-card">
    <div class="card-header bg-{{$color}} ">
        <h3 class="card-title">{{$title}} Compound</h3>
        <div class="card-tools text-light">
            <button type="button " class="btn btn-tool" data-card-widget="collapse">
                <i class="bx bx-minus bx-sm"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: block;">
    <form method="POST" action="#" wire:submit.prevent="save">
        @csrf
        <input type="submit" wire:click.prevent="" class="d-none">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="name" class=" col-form-label text-md-right">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.lazy="name"
                       name="name" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="code" class=" col-form-label text-md-right">Code</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" wire:model.lazy="code"
                       name="code" value="{{ old('code') }}">
                @error('code')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
                @foreach($activeElements as $index => $activeElements )
                <div class="col-md-7" >

                    <label for="element" class=" col-form-label text-md-right">Element</label>
                    <select class="form-control select-2" id="activeElements.{{$index}}.element"  wire:model.lazy="activeElements.{{$index}}.element">
                        <option value="">select Element</option>
                        @foreach($elements as $element)
                            <option value="{{$element->id}}">{{$element->name}} -- {{$element->code}}</option>
                        @endforeach
                    </select>

                    @error('activeElements.'.$index. '.element' )

                    <small class="text-danger">{{ $message }}</small>

                    @enderror

                    @error('activeElements.'.$index. '.percent' )

                    <small class="text-danger">{{ $message }}</small>

                    @enderror

                </div>
                <div class="col-md-3">
                    <label for="element" class=" col-form-label text-md-right">Percent</label>
                    <input type="number" step=".01" wire:model.lazy="activeElements.{{$index}}.percent"  class="form-control ">
                </div>
                <div class="col-2 mt-auto">
                    <button class="btn btn-danger" wire:click.prevent="removeElement({{$index}})">delete</button>
                </div>
            @endforeach
        </div>
        <h2>{{ number_format($total,2) }} % </h2>
        @if($errors->has('activeElements'))
            <span class="text-danger">{{ $errors->first('activeElements') }}</span>
        @endif
        <div class="form-group row mb-0 justify-content-between">
            <div class="col-md-6">
                <button wire:click.prevent="addElement()" class="btn btn-secondary">Add</button>
            </div>

            <div class="col-md-6">
                <button type="submit" class="btn btn-{{$color}}">
                    {{$button}}
                </button>
            </div>
        </div>
    </form>
    </div>
</div>


{{--@push('js')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $(id).select2({--}}
{{--                placeholder: "select Element",--}}
{{--                //   multiple: true,--}}
{{--                allowClear: true,--}}
{{--            });--}}
{{--            $('.select-2').each(function( index ) {--}}
{{--                console.log( index + ": " + $( this ).attr('id') );--}}
{{--                let id = $( this ).attr('id');--}}
{{--            --}}
{{--                $(id).on('change', function (e) {--}}
{{--                    var data = $(id).select2("val");--}}
{{--                    // let closeButton = $('.select2-selection__clear')[0];--}}
{{--                    // if(typeof(closeButton)!='undefined'){--}}
{{--                    //     if(data.length<=0)--}}
{{--                    //     {--}}
{{--                    //         $('.select2-selection__clear')[0].children[0].innerHTML = '';--}}
{{--                    //     } else{--}}
{{--                    //         $('.select2-selection__clear')[0].children[0].innerHTML = 'x';--}}
{{--                    //     }--}}
{{--                    // }--}}
{{--                @this.set('activeElements.'+index+'.element', data);--}}
{{--                });--}}
{{--            });--}}
{{--            // $('#category_id').select2({--}}
{{--            //     placeholder: "select Element",--}}
{{--            //     //   multiple: true,--}}
{{--            //     allowClear: true,--}}
{{--            // });--}}
{{--            // $('#category_id').on('change', function (e) {--}}
{{--            //     var data = $('#category_id').select2("val");--}}
{{--            //     let closeButton = $('.select2-selection__clear')[0];--}}
{{--            //     if(typeof(closeButton)!='undefined'){--}}
{{--            //         if(data.length<=0)--}}
{{--            //         {--}}
{{--            //             $('.select2-selection__clear')[0].children[0].innerHTML = '';--}}
{{--            //         } else{--}}
{{--            //             $('.select2-selection__clear')[0].children[0].innerHTML = 'x';--}}
{{--            //         }--}}
{{--            //     }--}}
{{--            // @this.set('category_id', data);--}}
{{--            // });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
