@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Formula</h1>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{route('formulas.index')}}">Manage Formulas</a>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

            <livewire:forms.formula-form />
            </div>
        </div>
    </div>





@endsection

{{--@section('js')--}}
{{--    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}

{{--    <script type="text/javascript">--}}
{{--    let i = 0;--}}
{{--    $("#dynamic-ar").click(function () {--}}
{{--        ++i;--}}
{{--        console.log($('#elements').val());--}}
{{--        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +--}}
{{--            '][subject]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'--}}
{{--        );--}}
{{--    });--}}
{{--    $(document).on('click', '.remove-input-field', function () {--}}
{{--        $(this).parents('tr').remove();--}}
{{--    });--}}
{{--</script>--}}
{{--    @stop--}}

