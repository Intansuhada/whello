@extends('app')
@section('content')
    <div class="form-login">
        <div class="form-container">
            <div class="logo">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="">
            </div>
            <div class="auth-title">Sign Up</div>

            <form action="{{ route('auth.signup') }}" method="POST">
                <div class="form-step active">
                    @csrf
                    <label for="email" class="email-label">Email</label>
                    <input id="email" name="email" class="email-input" value="{{ old('email') }}"
                        placeholder="Enter your work email" />
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="email-desc">Use your organization email for seamless team collaboration.</div>
                    <div class="btn-prev-next">
                        <a href="#" class="btn-form-step btn-next active">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <label for="email" class="email-label">Verification Code</label>
                    <input id="email" name="email" class="email-input" value="{{ old('email') }}"
                        placeholder="Enter code" />
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="email-desc">We've sent a verification code to your email. The code will expire in <b>21</b>
                        seconds. <a href="#" class="signin-link">Resend</a></div>
                    <div class="btn-prev-next">
                        <a href="#" class="btn-form-step btn-prev">Previous</a>
                        <a href="#" class="btn-form-step btn-next">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <label for="name" class="name-label">Username</label>
                    <input id="name" name="name" class="name-input" value="{{ old('name') }}"
                        placeholder="Choose a username" />
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="email-desc">Create a unique username for your account.</div>

                    <label for="password" class="password-label">Password</label>
                    <div class="input-password-signup">
                        <input type="password" id="password" name="password" class="password-input"
                            placeholder="Create a password" />
                        <img src="{{ asset('images/eye-slash.svg') }}" class="eyeicon-signup" id="eyeicon">
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="email-desc">Use a strong password with at least one uppercase letter, one lowercase letter,
                        one number, and one special character.</div>

                    <label for="confirm-password" class="confirm-password-label">Confirm Password</label>
                    <div class="input-password-signup">
                        <input type="password" id="confirm_password" name="password_confirmation"
                            class="confirm-password-input" placeholder="Confirm password" />
                        <img src="{{ asset('images/eye-slash.svg') }}" class="eyeicon-signup" id="eyeicon-confirm">
                    </div>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="email-desc">Re-enter your password to confirm.</div>
                    <div class="btn-prev-next">
                        <a href="#" class="btn-form-step btn-prev">Previous</a>
                        <a href="#" class="btn-form-step btn-next">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <label class="confirm-password-label">Workspace Name</label>
                    <input type="password" id="confirm_password_workspace" name="password_confirmation"
                        class="confirm-password-input" placeholder="Your workspace name" />
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="email-desc">Give your workspace a name (e.g., "Marketing Team", "Sales Department").</div>
                    <div class="btn-prev-next">
                        <a href="#" class="btn-form-step btn-prev end">Previous</a>
                    </div>
                    <button class="continue-button">Create Account</button>
                </div>

                <div class="signin-text">
                    <li class="profile-divider"></li>
                    <p>Or</p>
                    <li class="profile-divider"></li>
                </div>
            </form>
            <button class="google-login-button">
                <img src="{{ asset('images/google-logo.svg') }}" class="img-google-logo">
                Sign Up with Google Account
            </button>
            <div class="signin-text">
                Already have an account? <a href="{{ route('auth.signin-page') }}" class="signin-link">Sign In</a>
            </div>

        </div>
    </div>
@endsection
