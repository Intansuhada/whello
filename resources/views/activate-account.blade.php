@extends('app')

@section('content')
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="auth-card">
            <div class="auth-header">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="Logo" class="auth-logo">
                <h1>Aktivasi Akun</h1>
                <p>Lengkapi pengaturan akun Anda</p>
            </div>

            {{-- Unified Alert Section --}}
            @if ($errors->any())
                <div class="auth-alert error">
                    <div class="auth-alert-content">
                        <img src="{{ asset('images/close.svg') }}" alt="error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="auth-alert error">
                    <div class="auth-alert-content">
                        <img src="{{ asset('images/close.svg') }}" alt="error">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="auth-alert success">
                    <div class="auth-alert-content">
                        <img src="{{ asset('images/check.svg') }}" alt="success">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('activate-account', ['token' => $token]) }}" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="{{ $email }}" readonly 
                           class="form-control disabled">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-input">
                        <input type="password" id="password" name="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <img src="{{ asset('images/eye.svg') }}" alt="toggle" class="toggle-password">
                    </div>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-input">
                        <input type="password" id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               required>
                        <img src="{{ asset('images/eye.svg') }}" alt="toggle" class="toggle-password">
                    </div>
                    @error('password_confirmation')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Aktifkan Akun</button>
            </form>
        </div>
    </div>
</div>

<style>
.auth-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #F7FAFC;
    padding: 20px;
}

.auth-content {
    width: 100%;
    max-width: 400px;
}

.auth-card {
    background: white;
    padding: 32px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.auth-header {
    text-align: center;
    margin-bottom: 32px;
}

.auth-logo {
    width: 120px;
    margin-bottom: 24px;
}

.auth-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: #2D3748;
    margin-bottom: 8px;
}

.auth-header p {
    color: #718096;
    font-size: 16px;
}

.auth-form .form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #4A5568;
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #4299E1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
    outline: none;
}

.form-control.disabled {
    background: #EDF2F7;
    cursor: not-allowed;
}

.password-input {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    width: 20px;
    opacity: 0.5;
    transition: opacity 0.2s;
}

.toggle-password:hover {
    opacity: 0.8;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background: #4299E1;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-submit:hover {
    background: #3182CE;
}

.error {
    color: #E53E3E;
    font-size: 14px;
    margin-top: 4px;
}

.auth-alert {
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 24px;
}

.auth-alert.error {
    background: #FED7D7;
    border: 1px solid #F56565;
}

.auth-alert.success {
    background: #C6F6D5;
    border: 1px solid #48BB78;
}

.auth-alert-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.auth-alert-content img {
    width: 20px;
    height: 20px;
}

.auth-alert-content p {
    margin: 0;
    color: #2D3748;
    font-size: 14px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtns = document.querySelectorAll('.toggle-password');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            
            // Update icon
            this.src = type === 'password' 
                ? "{{ asset('images/eye.svg') }}"
                : "{{ asset('images/eye-off.svg') }}";
        });
    });
});
</script>
@endpush
@endsection
