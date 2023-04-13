@extends('layouts.master')
@section('content')
<div class="container">
    @if (session('error'))
    <div class="alert alert-danger" id="error">
        {{ session('error') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Email Verification</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{route('store')}}" id="otpform">
                        @csrf
                        <input type="hidden" name="name" value="{{$name}}">
                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="password" value="{{$password}}">
                        <input type="hidden" name="phone" value="{{$phone}}">

                        <div class="row mb-3">
                            <label for="otp" class="col-md-4 col-form-label text-md-end">Enter OTP</label>

                            <div class="col-md-6">
                                <input id="otp" type="number" class="form-control @error('otp') is-invalid @enderror" name="otp" autofocus>

                                @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Enter OTP
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#otpform").validate({
            rules: {
                otp: {
                    required: true
                    , minlength: 4
                    , maxlength: 4
                }
            , }
        , });
    });

</script>
@endsection
