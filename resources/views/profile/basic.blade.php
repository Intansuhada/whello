@extends('app')

@section('content')
    @include('partials.navbar')
    <div class="content">
        @include('partials.sidebar')
        
        <div class="profile-wrapper">
            @if(session('success') || session('error'))
                <div class="alert-message {{ session('error') ? 'alert-error' : 'alert-success' }}" id="alertMessage">
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <div class="profile-content">
                <h2>Basic Information</h2>
                <form action="{{ route('profile.update-basic') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="profile-content">
                        <h2>Basic Information</h2>
                        <form action="{{ route('profile.update-basic') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
        
                            <div class="form-section">
                                <label>Profile Photo</label>
                                <div class="avatar-upload">
                                    <div class="avatar-preview">
                                        <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : asset('images/change-photo.svg') }}" 
                                             alt="Profile Photo" 
                                             id="avatarPreview">
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" id="avatar" name="avatar" accept="image/*">
                                        <label for="avatar">Upload a new profile picture</label>
                                        @error('avatar')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
        
                            <div class="form-section">
                                <label for="nickname">Nickname</label>
                                <input type="text" id="nickname" name="nickname" 
                                       value="{{ old('nickname', $user->profile?->name) }}" 
                                       placeholder="How you want to be called"
                                       required>
                                @error('nickname')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
        
                            <div class="form-section">
                                <label for="full_name">Full Name</label>
                                <input type="text" id="full_name" name="full_name" 
                                       value="{{ old('full_name', $user->profile?->full_name) }}" 
                                       placeholder="Your full name"
                                       required>
                                @error('full_name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
        
                            <div class="form-section">
                                <label for="department_id">Department</label>
                                <input type="text" 
                                       value="{{ $user->profile?->department?->name ?? 'Not assigned' }}" 
                                       class="form-control" 
                                       readonly>
                            </div>
        
                            <div class="form-section">
                                <label for="job_title_id">Job Title</label>
                                <input type="text" 
                                       value="{{ $user->profile?->jobTitle?->name ?? 'Not assigned' }}" 
                                       class="form-control" 
                                       readonly>
                            </div>
        
                            <div class="form-section">
                                <label for="about">About</label>
                                <textarea id="about" name="about" rows="4" 
                                          placeholder="Tell us about yourself">{{ old('about', $user->profile?->about) }}</textarea>
                                @error('about')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
        
                            <div class="form-actions">
                                <button type="submit" class="btn-save">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    .profile-wrapper {
        padding: 24px;
        max-width: 800px;
        margin: 0 auto;
    }

    .profile-content {
        background: white;
        padding: 32px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .profile-content h2 {
        margin-bottom: 24px;
        color: #2D3748;
    }

    .form-section {
        margin-bottom: 24px;
    }

    .form-section label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #4A5568;
    }

    .form-section input[type="text"],
    .form-section select,
    .form-section textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-section input:focus,
    .form-section select:focus,
    .form-section textarea:focus {
        border-color: #4299E1;
        outline: none;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .avatar-upload {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-edit {
        flex: 1;
    }

    .avatar-edit input[type="file"] {
        display: none;
    }

    .avatar-edit label {
        display: inline-block;
        padding: 8px 16px;
        background: #EBF8FF;
        color: #3182CE;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .avatar-edit label:hover {
        background: #BEE3F8;
    }

    .btn-save {
        background: #4299E1;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-save:hover {
        background: #3182CE;
    }

    .error {
        color: #E53E3E;
        font-size: 13px;
        margin-top: 4px;
        display: block;
    }

    /* Alert Message Styles */
    .alert-message {
        margin-bottom: 20px;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 14px;
    }

    .alert-success {
        background-color: #C6F6D5;
        border: 1px solid #9AE6B4;
        color: #22543D;
    }

    .alert-error {
        background-color: #FED7D7;
        border: 1px solid #FEB2B2;
        color: #822727;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');

        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto-hide alert after 3 seconds
        const alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            setTimeout(() => {
                alertMessage.remove();
            }, 3000);
        }
    });
    </script>
@endsection
