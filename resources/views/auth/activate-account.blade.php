@extends('app')
@section('content')
    <div class="form-forgotpassword">
        <div class="form-container activate-account">
            <div class="logo-form-login">
                <img src="https://sementara.site/images/whello-logo.svg" alt="">
            </div>
            @if (session('success'))
                <h3>{!! session('success') !!}</h3>
            @else
                <div class="forgot-password">Activate Your Account</div>
                <p>Enter your new password to activate your account.</p>
                <form action="{{ route('activate-account', ['token' => $token]) }}" method="post">
                    @csrf

                    <label for="password" class="password-label">Password</label>
                    <div class="input-password-signup">
                        <input type="password" id="password" name="password" class="password-input" placeholder="Create a password"/>
                        <img src="{{ asset('images/eye-slash.svg') }}" class="eyeicon-signup" id="eyeicon" >
                    </div>
                    <p style="font-size: 12px" class="error">{{ $errors->first('password') }}</p>

                    <label for="confirm-password" class="confirm-password-label">Confirm Password</label>
                    <div class="input-password-signup">
                        <input type="password" id="confirm_password" name="password_confirmation" class="confirm-password-input" placeholder="Confirm password"/>
                        <img src="{{ asset('images/eye-slash.svg') }}" class="eyeicon-signup" id="eyeicon-confirm">
                    </div>

                    <button class="send-recovery-link-btn" type="submit">Activate</button>
                </form>
            @endif
        </div>
    </div>
@endsection