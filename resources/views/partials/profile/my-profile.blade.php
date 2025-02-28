<!-- Add this at the top of the file -->
<div class="alert-container"></div>

<!-- Basic Profile Section -->
<div class="profile-form-section" id="my-profile">
    <form id="profile-form" action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Photo Profile -->
        <div class="form-group">
            <h3>Photo Profile</h3>
            <p class="description">Please upload your photo with a maximum size of 2048 KB!</p>
            <div class="avatar-upload">
                <div class="avatar-preview">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/img/default-avatar.png') }}" 
                         alt="Profile Photo" 
                         id="avatarPreview">
                </div>
                <div class="avatar-actions">
                    <label for="avatarInput" class="btn-change-photo">Change Photo</label>
                    <input type="file" 
                           id="avatarInput" 
                           name="avatar" 
                           accept="image/jpeg,image/png,image/jpg" 
                           class="hidden">
                    @error('avatar')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="form-group">
            <h3>Basic Information</h3>
            <label for="nickname">Nickname</label>
            <input type="text" id="nickname" name="nickname" value="{{ auth()->user()->profile->nickname ?? '' }}">
            <p class="help-text">Nickname is used for identifying users in this platform.</p>
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="name" value="{{ auth()->user()->profile->name ?? '' }}">
            <p class="help-text">Full Name is used for identifying users in this platform.</p>
        </div>

        <div class="form-group">
            <label for="about">About Me</label>
            <textarea id="about" name="about" rows="4">{{ auth()->user()->profile->about ?? '' }}</textarea>
            <p class="help-text">Tell us something about yourself.</p>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department_id">
                <option value="">Select Department</option>
                @foreach($departments ?? [] as $dept)
                    <option value="{{ $dept->id }}" {{ (auth()->user()->profile->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            <p class="help-text">Department is a department that is associated with your job title.</p>
        </div>

        <div class="form-group">
            <label for="job_title">Job Title</label>
            <select id="job_title" name="job_title_id">
                <option value="">Select Job Title</option>
                @foreach($jobTitles ?? [] as $title)
                    <option value="{{ $title->id }}" {{ (auth()->user()->profile->job_title_id ?? '') == $title->id ? 'selected' : '' }}>
                        {{ $title->name }}
                    </option>
                @endforeach
            </select>
            <p class="help-text">Job title is a title that describes your job.</p>
        </div>

        <!-- Working Hours -->
        <div class="form-group working-hours">
            <h3>Default Working Days & Hours</h3>
            <p class="description">This is the default working days and hours that will be used for all tasks, projects, and holidays...</p>
            
            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                <div class="day-row">
                    <label>{{ $day }}</label>
                    <div class="time-slots">
                        <input type="time" name="hours[{{ strtolower($day) }}][am_start]">
                        <span>to</span>
                        <input type="time" name="hours[{{ strtolower($day) }}][am_end]">
                        <span>&</span>
                        <input type="time" name="hours[{{ strtolower($day) }}][pm_start]">
                        <span>to</span>
                        <input type="time" name="hours[{{ strtolower($day) }}][pm_end]">
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="form-actions">
            <button type="submit" class="btn-save">Save All Changes</button>
        </div>
    </form>
</div>

<!-- Account & Security Section -->
<div class="profile-form-section" id="account-security">
    <div class="account-security">
        <div class="account-security-info">
            <div class="form-group">
                <h3>Account & Security Settings</h3>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <p><strong>Phone Number</strong></p>
                <p class="help-text">This is phone number</p>
                <input type="text" name="phone" value="+6282288126962">
            </div>

            <!-- Username -->
            <div class="form-group">
                <p><strong>Username</strong></p>
                <p class="help-text">Username can be used for login.</p>
                <form action="{{ route('settings.profile.change-username') }}" id="form-change-username" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="username" value="{{ $user->username }}">
                </form>
                <span><a href="#" id="change-username">Change Username</a></span>
            </div>

            <!-- Email -->
            <div class="form-group">
                <p><strong>Email</strong></p>
                <p class="help-text">You can still log in with your current email address or your new one.</p>
                <form action="{{ route('settings.profile.verify-new-email') }}" id="form-change-email" method="post">
                    @csrf
                    <input type="email" name="email" value="{{ $user->email }}">
                </form>
                <span><a href="#" id="change-email">Change Email</a></span>
            </div>

            <!-- Password -->
            <div class="form-group">
                <p><strong>Password</strong></p>
                <p class="help-text">You can change your password here.</p>
                <div class="input-box">
                    <form action="{{ route('settings.profile.change-password') }}" id="form-change-password" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="password" name="password" id="password" placeholder="Password">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password">
                    </form>
                    <img src="{{ asset('images/eye-slash.svg') }}" id="eyeicon">
                    <div class="change">
                        <span><a href="#" id="change-password">Change Password</a></span>
                    </div>
                </div>
            </div>

            <!-- Two Factor Authentication -->
            <div class="form-group">
                <p><strong>Two Factor Authentication</strong></p>
                <p class="help-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="account-security">
                    <label for="account-security" class="button-toggle"></label>
                    <p>Activate Two Factor Authentication</p>
                </div>
            </div>

            <!-- Leave Workspace -->
            <div class="leave">
                <div class="button-leave">
                    <button>
                        <a href="">
                            <img src="{{ asset('images/export.svg') }}" alt="" class="icon">
                            <span>Leave From Workspace</span>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-form-section {
    padding: 24px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 24px;
}

.avatar-upload {
    display: flex;
    gap: 16px;
    align-items: center;
    margin-bottom: 24px;
}

.hidden {
    display: none;
}

.btn-change,
.btn-add-phone,
.btn-2fa,
.btn-save {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.btn-save {
    width: 100%;
    background: #3182CE;
    color: white;
    padding: 12px;
    font-size: 16px;
}

.working-hours .day-row {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
    align-items: center;
}

.time-slots {
    display: flex;
    gap: 8px;
    align-items: center;
}

.add-phone {
    display: flex;
    gap: 16px;
    align-items: center;
}

/* Additional styles for form inputs */
input[type="text"],
input[type="time"],
select,
textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #E2E8F0;
    border-radius: 4px;
}

.help-text {
    color: #718096;
    font-size: 14px;
    margin-top: 4px;
}

/* Additional styles for account security */
.account-security {
    margin-top: 24px;
}

.input-box {
    position: relative;
}

.toggle {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 16px;
}

.button-leave {
    margin-top: 24px;
}

.button-leave button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid #E53E3E;
    border-radius: 4px;
    background: transparent;
    color: #E53E3E;
    cursor: pointer;
}

.error-text {
    color: #E53E3E;
    font-size: 14px;
    margin-top: 4px;
}

.avatar-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
}

.btn-change-photo {
    background: #3182CE;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.alert-container {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    width: auto;
    min-width: 300px;
    max-width: 80%;
}

.alert {
    text-align: center;
    padding: 16px 24px;
    border-radius: 8px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    animation: slideDown 0.3s ease-out;
}

.alert-success {
    background-color: #C6F6D5;
    border: 1px solid #68D391;
    color: #2F855A;
}

.alert-error {
    background-color: #FED7D7;
    border: 1px solid #FC8181;
    color: #C53030;
}

@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profile-form');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    // Handle avatar preview
    avatarInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            
            // Validate file size (2MB = 2048KB)
            if (file.size > 2048 * 1024) {
                showAlert('File size must be less than 2MB', 'error');
                this.value = '';
                return;
            }

            // Validate file type
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                showAlert('Please upload only jpeg, jpg or png files', 'error');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle form submission
    profileForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const formData = new FormData(this);
            
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Saving...';

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
                showAlert('Profile updated successfully', 'success');
                
                // Update avatar if new URL is provided
                if (result.data.avatar_url) {
                    avatarPreview.src = result.data.avatar_url;
                }
                
                // Optional: reload the page after successful update
                setTimeout(() => window.location.reload(), 1500);
            } else {
                throw new Error(result.message || 'Failed to update profile');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert(error.message || 'Failed to update profile', 'error');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Save All Changes';
        }
    });

    function showAlert(message, type) {
        const alertContainer = document.querySelector('.alert-container');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = message;
        
        // Remove existing alerts
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alert);
        
        // Remove alert after 3 seconds
        setTimeout(() => {
            alert.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => {
                if (alertContainer.contains(alert)) {
                    alertContainer.removeChild(alert);
                }
            }, 300);
        }, 3000);
    }
});
</script>