@extends('app')

@section('content')
<div class="activate-account-container">
    <h2>Aktivasi Akun Anda</h2>
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('users.activate.process', $token) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="password">Buat Password Baru</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                placeholder="Minimal 8 karakter"
            >
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                required
                placeholder="Masukkan password yang sama"
            >
        </div>

        <button type="submit" class="activate-btn">Aktifkan Akun</button>
    </form>
</div>
@endsection
