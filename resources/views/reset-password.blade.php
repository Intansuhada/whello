@extends('app')

@section('content')
    <div class="form-forgotpassword">
        <div class="form-container">
            <div class="logo">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="">
            </div>
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {!! session('success') !!}
            </div>
            @endif
            
            <div class="forgot-password">Reset Your Password</div>
            
            <form action="{{ route('reset-password', ['token' => $token]) }}" method="post">
                @csrf
                <label for="password" class="password-label">Password</label>
                <input type="password" id="password" name="password" class="password-input" />

                <p style="font-size: 12px" class="error">{{ $errors->first('password') }}</p>

                <label for="password_confirmation" class="password-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="password-input" />

                <button class="send-recovery-link-btn" type="submit">Reset Password</button>
            </form>
        </div>
    </div>
@endsection
