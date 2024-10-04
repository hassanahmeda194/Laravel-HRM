@extends('Layout.auth-master')
@section('main_section')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-4">
                                <h5 class="text-primary">OTP Verification</h5>
                                <p>Enter the OTP sent to your email.</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <a href="index-2.html">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle"
                                        height="34">
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="p-2">
                        @session('success')
                            <div class="alert alert-success text-center mb-4" role="alert">
                                {{ $value }}
                            </div>
                        @endsession
                        <form class="form-horizontal" action="{{ route('submit.otp.verification') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" class="form-control" name="otp" placeholder="Enter OTP">
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button class="btn btn-primary w-md waves-effect waves-light w-100" type="submit">Verify
                                    OTP</button>
                            </div>
                            <div class="d-flex gap-4 my-4 justify-content-center">
                                <a href="{{ route('again.otp.verification') }}">send opt again</a>
                                <a href="{{ route('logout') }}">Logout</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
