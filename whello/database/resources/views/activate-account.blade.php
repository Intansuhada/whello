@extends('app')
@section('content')
    <div class="form-forgotpassword">
        <div class="form-container">
            <div class="logo">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="">
            </div>
            @if (session('success'))
                <h3>{!! session('success') !!}</h3>
            @else
                <div class="forgot-password">Activate Your Account</div>
                <p>Enter your new password to activate your account.</p>
                <form action="{{ route('activate-account', ['token' => $token]) }}" method="post">
                    @csrf
                    <label for="password" class="password-label">Password</label>
                    <input type="password" id="password" name="password" class="password-input" />
                    <p style="font-size: 12px" class="error">{{ $errors->first('password') }}</p>

                    <label for="password_confirmation" class="password-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="password-input" />

                    <button class="send-recovery-link-btn" type="submit">Activate</button>
                </form>
            @endif
        </div>
    </div>
@endsection
