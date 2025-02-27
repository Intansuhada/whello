@extends('app')

@section('content')
    <div class="form-login">
        <div class="form-container">
            <div class="logo">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="">
            </div>
            @if (session('success'))
                <h3>Reset Email Sent</h3>
                <br>
                <p>{{ session('success') }}</p>
                <br>
                <p><a href="{{ route('auth.signin-page') }}" class="continue-button" style="padding: 8px; text-decoration: none;">Return to Sign In</a></p>
            @else
                <div class="auth-title">Forgot Your Password?</div>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('send-email') }}" method="post">
                    @csrf
                    <label for="email" class="email-label">Email</label>
                    <input type="email" name="email" id="email" class="email-input"
                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                    <div class="email-desc">We'll send a password reset link to this email.</div>
                    <button class="continue-button">Send Recovery Link</button>
                </form>

                <!-- Return to Sign In Link -->
                <div class="signin-text">
                    Return to <a href="{{ route('auth.signin-page') }}" class="signin-link">Sign In</a>
                </div>
            @endif
        </div>
    </div>
@endsection
