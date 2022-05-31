@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Client</h1>
    <a href="{{ route('crm.clients.index') }}" class="btn btn-outline-primary">All Clients</a>
@stop
@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">


                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('crm.clients.store') }}">
                    @csrf
                    <input name="vat" type="hidden" value="0"  >
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="name" class=" col-form-label text-md-right">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class=" col-form-label text-md-right">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  autocomplete="phone">

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="status" class=" col-form-label text-md-right">Status</label>
                            <select name="status_id" class="form-control "  >
                                <option value="">Select Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                            <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="company" class=" col-form-label text-md-right">Company</label>
                            <select name="company_id" class="form-control "  >
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>

                                @endforeach
                            </select>
                            @error('company_id')
                            <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-md-5">
                        <label for="type" class=" col-form-label text-md-right">{{ __('Type') }}</label>
                        <select name="type" class="form-control "  >
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{$type}}">{{$type}}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                        <div class="col-md-5">
                            <label for="payment" class=" col-form-label text-md-right">{{ __('Payment') }}</label>
                            <select name="payment" class="form-control "  >
                                <option value="">Select Payment</option>
                                @foreach($payments as $payment)
                                    <option value="{{$payment}}">{{$payment}}</option>
                                @endforeach
                            </select>
                            @error('payment')
                            <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="vat" class=" col-form-label text-md-right">VAT</label>
                            <input name="vat" type="checkbox"  value="1" class="form-control "  >
                            @error('vat')
                            <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="location" class=" col-form-label text-md-right">{{ __('Location') }}</label>
                            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}"  autocomplete="location" >

                            @error('location')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 ">
                            <button type="submit" class="btn btn-success">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection

