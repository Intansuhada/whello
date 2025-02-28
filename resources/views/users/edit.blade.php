@extends('app')

@section('content')
<div class="container">
    <div class="edit-user-form">
        <h2>Edit User</h2>
        
        <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Profile Picture</label>
                <div class="avatar-upload">
                    <div class="avatar-preview">
                        <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : asset('images/default-avatar.png') }}" 
                             alt="Profile Picture" 
                             id="avatarPreview">
                    </div>
                    <div class="avatar-actions">
                        <label for="avatarInput" class="btn-change">Change Photo</label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ $user->profile->name ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department_id">
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ ($user->profile->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="job_title">Job Title</label>
                <select id="job_title" name="job_title_id">
                    <option value="">Select Job Title</option>
                    @foreach($jobTitles as $title)
                        <option value="{{ $title->id }}" {{ ($user->profile->job_title_id ?? '') == $title->id ? 'selected' : '' }}>
                            {{ $title->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save Changes</button>
                <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
.edit-user-form {
    max-width: 600px;
    margin: 40px auto;
    padding: 24px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.avatar-upload {
    display: flex;
    gap: 16px;
    align-items: center;
}

.avatar-preview img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}

.hidden {
    display: none;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 24px;
}

.btn-save, .btn-cancel {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-save {
    background: #3182CE;
    color: white;
    border: none;
}

.btn-cancel {
    background: #E2E8F0;
    color: #4A5568;
    text-decoration: none;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editUserForm');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    // Handle avatar preview
    avatarInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const formData = new FormData(this);
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            
            if (result.success) {
                alert('User updated successfully');
                window.location.href = '{{ route("users.index") }}';
            } else {
                throw new Error(result.message || 'Failed to update user');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Failed to update user');
        }
    });
});
</script>
@endpush
