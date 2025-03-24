<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="alert-container"></div>

<div class="account-security-settings-content">
    <div id="alertContainer" class="mb-4" style="display: none;">
        <div class="alert alert-dismissible fade show" role="alert">
            <span id="alertMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <form id="profileForm" action="{{ route('profile.update-profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="settings-group">
            <h2 class="settings-title">Profile Settings</h2>
            
            <div class="settings-card">
                <!-- Avatar Section -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Profile Photo</h3>
                        <p class="text-muted">Upload a new profile picture</p>
                    </div>
                    <div class="settings-input">
                        <div class="profile-photo-container">
                            <div class="profile-photo-wrapper">
                                <img src="{{ $user->profile?->avatar ? Storage::url($user->profile->avatar) : asset('images/default-avatar.png') }}" 
                                     alt="Profile Photo" 
                                     id="avatarPreview"
                                     class="profile-photo">
                                <div class="photo-overlay">
                                    <label for="avatarInput" class="upload-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Change Photo</span>
                                    </label>
                                    <button type="button" class="delete-photo-btn" id="deletePhotoBtn" 
                                            {{ !$user->profile?->avatar ? 'style=display:none' : '' }}>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nickname -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Full Name</h3>
                        <p class="text-muted">Your full name</p>
                    </div>
                    <div class="settings-input">
                        <input type="text" class="form-control" name="nickname" 
                               value="{{ $user->profile?->nickname }}" required>
                    </div>
                </div>

                <!-- Full Name -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Nick Name</h3>
                        <p class="text-muted">How you want to be called</p>
                    </div>
                    <div class="settings-input">
                        <input type="text" class="form-control" name="name" 
                               value="{{ $user->profile?->name }}" required>
                    </div>
                </div>

                <!-- Department -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Department</h3>
                        <p class="text-muted">Your department in the organization</p>
                    </div>
                    <div class="settings-input">
                        @if($user->profile?->department)
                            <input type="text" class="form-control" value="{{ $user->profile->department->name }}" readonly>
                            <input type="hidden" name="department_id" value="{{ $user->profile->department_id }}">
                        @else
                            <input type="text" class="form-control" value="Not assigned" readonly>
                        @endif
                    </div>
                </div>

                <!-- Job Title -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Job Title</h3>
                        <p class="text-muted">Your role in the organization</p>
                    </div>
                    <div class="settings-input">
                        @if($user->profile?->jobTitle)
                            <input type="text" class="form-control" value="{{ $user->profile->jobTitle->name }}" readonly>
                            <input type="hidden" name="job_title_id" value="{{ $user->profile->job_title_id }}">
                        @else
                            <input type="text" class="form-control" value="Not assigned" readonly>
                        @endif
                    </div>
                </div>

                <!-- About -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>About</h3>
                        <p class="text-muted">Tell us about yourself</p>
                    </div>
                    <div class="settings-input">
                        <textarea class="form-control" name="about" rows="4">{{ $user->profile?->about }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="settings-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<style>
/* Use the same styles as account-security-settings.blade.php */
.account-security-settings-content {
    padding: 24px;
}

.settings-title {
    font-size: 24px;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 24px;
}

.settings-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.settings-item {
    padding: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.settings-item:last-child {
    border-bottom: none;
}

.settings-header {
    margin-bottom: 16px;
}

.settings-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.settings-header p {
    font-size: 14px;
    color: #718096;
    margin: 0;
}

.settings-input {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.form-control {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
}

.help-text {
    font-size: 12px;
    color: #718096;
    margin-top: 4px;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-primary {
    background-color: #4299e1;
    color: white;
    border: none;
}

.btn-secondary {
    background-color: #edf2f7;
    color: #2d3748;
    border: 1px solid #e2e8f0;
}

.settings-actions {
    margin-top: 24px;
}

@media (max-width: 640px) {
    .settings-input {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}

.profile-photo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.profile-photo-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e2e8f0;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: filter 0.2s;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.profile-photo-wrapper:hover .photo-overlay {
    opacity: 1;
}

.profile-photo-wrapper:hover .profile-photo {
    filter: blur(2px);
}

.upload-overlay {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    cursor: pointer;
    width: 100%;
    height: 100%;
    justify-content: center;
}

.upload-overlay i {
    font-size: 24px;
    margin-bottom: 8px;
}

.upload-overlay span {
    font-size: 14px;
    text-align: center;
}

.delete-photo-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    display: none; /* Ubah dari flex ke none */
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #ef4444;
    font-size: 14px;
    transition: all 0.2s;
    z-index: 20;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.delete-photo-btn:hover {
    background: #ef4444;
    color: white;
}

/* Tambahkan style baru untuk mengatur visibility button delete */
.profile-photo-wrapper:hover .delete-photo-btn {
    display: flex;
}

.form-control {
    width: 100%;
    transition: all 0.2s;
    background-color: white;
}

.form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
}

.form-control[readonly] {
    background-color: #f7fafc;
    cursor: not-allowed;
    color: #4a5568;
    border-color: #e2e8f0;
}

.form-control[readonly]:focus {
    border-color: #e2e8f0;
    box-shadow: none;
}

.readonly-field {
    background-color: #f7fafc;
    padding: 8px 12px;
    border-radius: 6px;
    color: #4a5568;
    border: 1px solid #e2e8f0;
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

select.form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
}

/* Enhanced Alert Styles */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    position: relative;
    margin-bottom: 1rem;
    border-left: 4px solid;
    animation: slideIn 0.3s ease-in-out;
}

.alert-success {
    background-color: #f0fdf4;
    border-color: #22c55e;
    color: #15803d;
    box-shadow: 0 2px 4px rgba(34, 197, 94, 0.1);
}

.alert-danger {
    background-color: #fef2f2;
    border-color: #ef4444;
    color: #b91c1c;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.1);
}

.btn-close {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    opacity: 0.5;
    transition: opacity 0.2s;
    padding: 0.5rem;
}

.btn-close:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(-100%);
        opacity: 0;
    }
}

#alertContainer {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    min-width: 300px;
    max-width: 500px;
}

.alert-icon {
    display: inline-flex;
    align-items: center;
    margin-right: 0.5rem;
}

.alert-content {
    display: flex;
    align-items: center;
}

/* Success Icon */
.alert-success .alert-icon::before {
    content: '✓';
    background-color: #22c55e;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    margin-right: 8px;
}

/* Error Icon */
.alert-danger .alert-icon::before {
    content: '!';
    background-color: #ef4444;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    margin-right: 8px;
}

.btn-danger {
    background-color: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.btn-danger:hover {
    background-color: #fecaca;
}

.btn-danger:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.upload-btn-wrapper {
    display: flex;
    gap: 8px;
}

.hidden {
    display: none;
    visibility: hidden;
    position: absolute;
    left: -9999px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const alertContainer = document.getElementById('alertContainer');
    const alertElement = alertContainer.querySelector('.alert');
    const alertMessage = document.getElementById('alertMessage');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const deletePhotoBtn = document.getElementById('deletePhotoBtn');

    function showAlert(message, type = 'success') {
        alertMessage.innerHTML = `
            <div class="alert-content">
                <span class="alert-icon"></span>
                ${message}
            </div>
        `;
        alertElement.classList.remove('alert-success', 'alert-danger');
        alertElement.classList.add(`alert-${type}`);
        alertContainer.style.display = 'block';
        
        // Auto hide after 3 seconds with animation
        setTimeout(() => {
            alertElement.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => {
                alertContainer.style.display = 'none';
                alertElement.style.animation = '';
            }, 300);
        }, 3000);
    }

    // Handle avatar preview
    avatarInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
                deletePhotoBtn.style.display = 'flex';
            };
            
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                showAlert(result.message, 'success');
                if (result.data.avatar_url) {
                    avatarPreview.src = result.data.avatar_url;
                }
            } else {
                showAlert(result.message, 'danger');
            }
        } catch (error) {
            showAlert('Gagal menyimpan perubahan', 'danger');
        }
    });

    deletePhotoBtn.addEventListener('click', async function() {
        if (!confirm('Are you sure you want to delete your profile photo?')) {
            return;
        }

        try {
            const response = await fetch('{{ route("profile.delete-photo") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                avatarPreview.src = result.data.avatar_url;
                showAlert(result.message, 'success');
                this.disabled = true;
            } else {
                showAlert(result.message, 'danger');
            }
        } catch (error) {
            showAlert('Gagal menghapus foto profil', 'danger');
        }
    });
});
</script>