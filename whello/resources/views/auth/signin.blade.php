@extends('app')

@section('content')
<div class="body-login">
    <div class="form-login">
        <div class="form-container">
            <div class="logo-form-login">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="">
            </div>
            <div class="auth-title">Welcome Back</div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('auth.signin') }}" method="post">
                @csrf
                <label for="email" class="email-label">Email</label>
                <input type="email" id="email" name="email" class="email-input" value="{{ old('email') }}" placeholder="Enter your email" required/>
                <div class="email-desc">you can also use your phone number</div>
                <label for="password" class="password-label">Password</label>

                <div class="input-password-signin">
                    <input type="password" id="password" name="password" class="password-input" placeholder="Enter your password" />
                    <img src="{{ asset('images/eye-slash.svg') }}" class="eyeicon-signin" id="eyeicon" >
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="checkbox-remember-me">
                    <label for="checkbox-remember-me" style="font-size: 12px;">Remember me</label>
                    <a href="{{ route('forgot-password-page') }}" class="signin-link" style="font-size: 12px;">Forgot Password?</a>
                </div>

                <button class="continue-button" type="submit">Sign In</button>
                <div class="signin-text">            
                    <li class="profile-divider"></li><p>Or</p><li class="profile-divider"></li>
                </div>
            </form>
            <button class="google-login-button">
                <img src="{{ asset('images/google-logo.svg') }}" class="img-google-logo">
                Sign In with Google Account
            </button>
            <div class="signin-text">
                Don't have an account? <a href="{{ route('auth.signup-page') }}" class="signin-link">Create an Account</a>
            </div>
        </div>
    </div>
</div>
@endsection
