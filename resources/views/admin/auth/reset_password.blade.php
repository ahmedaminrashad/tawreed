@extends('admin.auth.layouts.master')

@section('title', 'Reset Your Password')

@section('content')

<div class="container">
    @include('admin.layouts.flash_msg')
</div>

<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('admin.home') }}"><b>Zawaya Dashboard</a>
    </div>
    <!-- /.login-logo -->
    <div class="card-body login-card-body">
        <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

        <form action="{{ route('admin.reset.password') }}" method="post">
            @csrf
            <input type="hidden" name="token" id="token" value="{{ $tokenData->token }}">
            <input type="hidden" name="email" id="email" value="{{ $tokenData->email }}">
            <div class="input-group mb-3">
                <label class="form-control">{{ old('email', $tokenData->email) }}</label>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Change password</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mt-3 mb-1">
            <a href="{{ route('admin.login.form') }}">Login</a>
        </p>
    </div>
</div>
<!-- /.login-box -->

@endsection
