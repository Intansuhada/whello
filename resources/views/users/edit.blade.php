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
                <label for="name">Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $selectedUser->profile->name ?? '') }}" 
                       required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
                <div class="error-message" id="name-error"></div>
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

.form-working-day {
    margin-bottom: 20px;
    background: #f9fafb;
    padding: 16px;
    border-radius: 8px;
}

.form-working-day p {
    color: #4A5568;
    line-height: 1.6;
}

.working-days-container {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
}

.working-day-row {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #E2E8F0;
}

.working-day-row:last-child {
    border-bottom: none;
}

.day-selector {
    display: flex;
    align-items: center;
    margin-right: 20px;
    width: 150px;
}

.day-selector input[type="radio"] {
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #CBD5E0;
    margin-right: 10px;
    outline: none;
    cursor: pointer;
}

.day-selector input[type="radio"]:checked {
    border-color: #4299E1;
    background-color: #4299E1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.day-selector label {
    cursor: pointer;
    color: #2D3748;
}

.day-hours {
    flex-grow: 1;
}

.time-slot {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #4A5568;
}

.time-slot span {
    white-space: nowrap;
}

.time-slot span:nth-child(2),
.time-slot span:nth-child(4) {
    color: #718096;
    margin: 0 5px;
}
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

.error-field {
    border-color: #ef4444 !important;
    background-color: #fff5f5;
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: none;
}

.error-message.visible {
    display: block;
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

    // Fungsi untuk menampilkan error
    function showError(field, message) {
        // Hapus error yang ada sebelumnya
        clearError(field);
        
        // Tambah class error pada input
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('error-field');
            
            // Tampilkan pesan error
            const errorDiv = document.getElementById(`${field}-error`);
            if (errorDiv) {
                errorDiv.textContent = message;
                errorDiv.classList.add('visible');
            }
        }
    }

    // Fungsi untuk membersihkan error
    function clearError(field) {
        const input = document.querySelector(`[name="${field}"]`);
        const errorDiv = document.getElementById(`${field}-error`);
        
        if (input) {
            input.classList.remove('error-field');
        }
        
        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.classList.remove('visible');
        }
    }

    // Fungsi untuk membersihkan semua error
    function clearAllErrors() {
        document.querySelectorAll('.error-field').forEach(el => {
            el.classList.remove('error-field');
        });
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
            el.classList.remove('visible');
        });
    }

    // Validasi sebelum submit
    function validateForm() {
        let isValid = true;
        const nameInput = document.querySelector('[name="name"]');
        
        // Reset error
        clearAllErrors();
        
        // Cek name field
        if (!nameInput.value.trim()) {
            showError('name', 'Name field is required');
            isValid = false;
        }
        
        return isValid;
    }

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validasi form sebelum submit
        if (!validateForm()) {
            return false;
        }
        
        try {
            const formData = new FormData(this);
            
            // Debug: Log form data
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            console.log('Response:', result); // Debug response
            
            if (!result.success) {
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        showError(field, result.errors[field][0]);
                    });
                }
                return;
            }

            // Sukses
            if (result.redirect) {
                window.location.href = result.redirect;
            }

        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Clear error ketika user mulai mengetik
    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', function() {
            clearError(this.name);
        });
    });
});
</script>
@endpush
