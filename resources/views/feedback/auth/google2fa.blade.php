@extends('feedback.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Set up Google Authenticator</div>

                    <div class="panel-body" style="text-align: center;">
                        <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                        <div>





                            @php echo DNS2D::getBarcodeHTML($secret,'QRCODE'); @endphp

                            <img src="data:image/png;base64,{{ $QR_Image }}" />
                        </div>
                        <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                        <div>
                            <form action="{{route('feedback.complete.register')}}" method="POST" >
                                @csrf
                           <button type="submit" class="btn btn-primary">Complete Registration</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
