<div class="account-security-settings-content">
    <!-- Add alert container -->
    <div id="alertContainer" class="mb-4" style="display: none;">
        <div class="alert alert-dismissible fade show" role="alert">
            <span id="alertMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <form id="accountSecurityForm">
        @csrf
        <div class="settings-group">
            <h2 class="settings-title">Account & Security Settings</h2>

            <div class="settings-card">
                <!-- Phone Number -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Phone Number</h3>
                        <p class="text-muted">This is phone number</p>
                    </div>
                    <div class="settings-input">
                        <input type="text" class="form-control" name="phone_number" value="{{ $user->profile->phone ?? '' }}" placeholder="Enter phone number">
                    </div>
                </div>

                <!-- Username -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Username</h3>
                        <p class="text-muted">Username can be used for login.</p>
                    </div>
                    <div class="settings-input">
                        <input type="text" class="form-control" name="username" value="{{ $user->username ?? '' }}" placeholder="Enter username">
                    </div>
                </div>

                <!-- Email -->
                <div class="settings-item">
                    <div class="settings-header">
                    </div>
                    <div class="settings-input">
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
                </div>

                <!-- Password -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Password</h3>
                        <p class="text-muted">You can change your password here.</p>
                    </div>
                    <div class="settings-input">
                        <button type="button" class="btn btn-secondary">Change Password</button>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="settings-item" id="passwordChangeSection" style="display: none;">
                    <div class="settings-header">
                        <h3>Change Password</h3>
                        <p class="text-muted">Enter your current password and new password</p>
                    </div>
                    <div class="settings-input">
                        <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                    </div>
                    <div class="settings-input mt-3">
                        <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    </div>
                    <div class="settings-input mt-3">
                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="Confirm New Password">
                    </div>
                </div>

                <!-- Two Factor Authentication -->
                <div class="settings-item">
                    <div class="settings-header">
                        <h3>Two Factor Authentication</h3>
                        <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                    <div class="settings-input">
                        <div class="toggle-wrapper">
                            <label class="switch">
                                <input type="checkbox" name="two_factor">
                                <span class="slider round"></span>
                            </label>
                            <span class="toggle-label">Activate Two Factor Authentication</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="settings-actions">
            <button type="submit" class="btn btn-primary">Save All Changes</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('accountSecurityForm');
    const changePasswordBtn = document.querySelector('.btn-secondary');
    const passwordSection = document.getElementById('passwordChangeSection');
    const alertContainer = document.getElementById('alertContainer');
    const alertElement = alertContainer.querySelector('.alert');
    const alertMessage = document.getElementById('alertMessage');

    function showAlert(message, type = 'success') {
        const icon = type === 'success' 
            ? '<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>'
            : '<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';

        alertMessage.innerHTML = `
            <div class="alert-content">
                ${icon}
                <strong>${message}</strong>
            </div>
        `;
        alertElement.classList.remove('alert-success', 'alert-danger');
        alertElement.classList.add(`alert-${type}`);
        alertContainer.style.display = 'block';
        alertContainer.style.animation = 'fadeInOut 2s ease-in-out forwards';
        
        setTimeout(() => {
            alertContainer.style.display = 'none';
        }, 2000);
    }

    window.hideAlert = function() {
        alertContainer.style.animation = 'fadeOutScale 0.2s ease-out forwards';
        setTimeout(() => {
            alertContainer.style.display = 'none';
            alertContainer.style.animation = '';
        }, 200);
    }

    function resetPasswordFields() {
        document.querySelectorAll('input[type="password"]').forEach(input => {
            input.value = '';
        });
        passwordSection.style.display = 'none';
    }

    changePasswordBtn.addEventListener('click', () => {
        passwordSection.style.display = passwordSection.style.display === 'none' ? 'block' : 'none';
    });

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const response = await fetch('/profile/security/update', {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                showAlert(result.message, 'success');
                resetPasswordFields();
            } else {
                showAlert(result.message, 'danger');
            }
        } catch (error) {
            showAlert('Gagal menyimpan data', 'danger');
        }
    });
});
</script>

<style>
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
    align-items: center;
}

.settings-input .form-control {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
}

.settings-input .form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    outline: none;
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

.btn-primary:hover {
    background-color: #3182ce;
}

.btn-secondary {
    background-color: #edf2f7;
    color: #2d3748;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background-color: #e2e8f0;
}

.settings-actions {
    margin-top: 24px;
    padding: 0 24px;
}

.toggle-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e0;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

.slider.round {
    border-radius: 24px;
}

.slider.round:before {
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4299e1;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.toggle-label {
    font-size: 14px;
    color: #2d3748;
}

@media (max-width: 640px) {
    .settings-input {
        flex-direction: column;
        align-items: stretch;
    }
    
    .settings-input .btn {
        width: 100%;
    }
}

/* Update Alert Container and Alert Styles */
#alertContainer {
    position: relative;
    width: 100%;
    margin: 0 0 24px;
}

.alert {
    position: relative;
    padding: 14px;
    border-radius: 8px;
    background: white;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #dbeafe;
    background-color: #eff6ff;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    justify-content: center;
}

.alert-icon {
    width: 20px;
    height: 20px;
    color: #2563eb;
}

.alert strong {
    font-size: 14px;
    color: #1e40af;
    font-weight: 500;
}

/* Menghapus style untuk alert-success dan alert-danger yang mengubah warna background */
.alert-success, .alert-danger {
    background-color: #eff6ff;
    border-color: #dbeafe;
    color: #1e40af;
}

@keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(-8px); }
    15% { opacity: 1; transform: translateY(0); }
    85% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-8px); }
}

.alert-success {
    background: #f0fdf4;
    border-color:  #1e40af;
    color:  #1e40af;

}

.alert-danger {
    background: #fef2f2;
    border-color: #ef4444;
    color: #b91c1c;
}

.btn-close {
    position: absolute;
    right: 1rem;
    top: 1rem;
    padding: 0.5rem;
    background: transparent;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
}
</style>
