document.addEventListener('DOMContentLoaded', function() {
    // Modal handling
    const inviteBtn = document.getElementById('invite-btn');
    const invitePopup = document.getElementById('invite-popup');
    const closeBtn = document.getElementById('popup-close-btn');

    inviteBtn.addEventListener('click', () => {
        invitePopup.style.display = 'block';
    });

    closeBtn.addEventListener('click', () => {
        invitePopup.style.display = 'none';
    });

    // Form submission handling
    const inviteForm = document.getElementById('invite-form');
    inviteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData // Changed this to use FormData directly
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                invitePopup.style.display = 'none';
                showNotification(data.success, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.error || 'Failed to send invitation', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to send invitation', 'error');
        });
    });

    // User selection and editing
    const editBtn = document.querySelector('.users-edit-btn');
    const removeBtn = document.querySelector('.users-rmv-btn');
    let selectedUserId = null;

    document.querySelectorAll('.user-profile').forEach(profile => {
        profile.addEventListener('click', function() {
            selectedUserId = this.dataset.userId;
            document.querySelectorAll('.user-profile').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            loadUserDetails(selectedUserId);
        });
    });

    if (editBtn) {
        editBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah event bubbling
            const activeUser = document.querySelector('.user-profile.active');
            if (activeUser) {
                const userId = activeUser.getAttribute('data-user-id');
                window.location.href = `/users/${userId}/edit`;
            }
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', async function(e) {
            e.stopPropagation(); // Mencegah event bubbling
            const activeUser = document.querySelector('.user-profile.active');
            if (!activeUser) return;

            const userId = activeUser.getAttribute('data-user-id');
            const userName = activeUser.querySelector('.profile-name').textContent;

            if (confirm(`Apakah Anda yakin ingin menghapus ${userName}?`)) {
                try {
                    const response = await fetch(`/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        // Hapus elemen user dari DOM
                        activeUser.remove();
                        // Reset tampilan detail
                        document.getElementById('userDetailSection').style.display = 'none';
                        document.getElementById('tabMenuSection').style.display = 'none';
                        document.getElementById('tabContentSection').style.display = 'none';
                        document.getElementById('noUserSelected').style.display = 'flex';
                        
                        // Tampilkan notifikasi sukses
                        const notification = document.createElement('div');
                        notification.className = 'notify-popup';
                        notification.innerHTML = `
                            <div class="notify-invite">
                                <div class="notify-content">
                                    <p>User berhasil dihapus</p>
                                    <button type="button" class="oke-btn">Oke</button>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(notification);
                        setTimeout(() => notification.remove(), 3000);
                    } else {
                        alert(data.error || 'Gagal menghapus user');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error saat menghapus user');
                }
            }
        });
    }

    // Perbaikan fungsi edit dan remove
    document.querySelector('.users-edit-btn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const activeUser = document.querySelector('.user-profile.active');
        if (!activeUser) {
            showNotification('Pilih user terlebih dahulu', 'error');
            return;
        }

        const userId = activeUser.getAttribute('data-user-id');
        if (userId) {
            window.location.href = `/users/${userId}/edit`;
        }
    });

    document.querySelector('.users-rmv-btn').addEventListener('click', async function(e) {
        e.preventDefault();
        e.stopPropagation();
        const activeUser = document.querySelector('.user-profile.active');
        if (!activeUser) {
            showNotification('Pilih user terlebih dahulu', 'error');
            return;
        }

        const userId = activeUser.getAttribute('data-user-id');
        const userName = activeUser.querySelector('.profile-name').textContent;

        if (confirm(`Apakah Anda yakin ingin menghapus ${userName}?`)) {
            try {
                const response = await fetch(`/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    // Hapus element dari DOM
                    activeUser.remove();
                    
                    // Reset tampilan detail
                    document.getElementById('userDetailSection').style.display = 'none';
                    document.getElementById('tabMenuSection').style.display = 'none';
                    document.getElementById('tabContentSection').style.display = 'none';
                    document.getElementById('noUserSelected').style.display = 'flex';
                    
                    showNotification('User berhasil dihapus', 'success');
                } else {
                    showNotification(data.error || 'Gagal menghapus user', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error saat menghapus user', 'error');
            }
        }
    });

    function loadUserDetails(userId) {
        fetch(`/users/${userId}/details`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateUserDetails(data.user);
                    disableEditing();
                }
            })
            .catch(error => showNotification('Failed to load user details', 'error'));
    }

    function updateUserDetails(user) {
        document.getElementById('detail-name').textContent = user.name || user.email;
        document.getElementById('detail-id').textContent = `ID: ${user.id}`;
        document.getElementById('full-name').value = user.name || '';
        document.getElementById('job-title').value = user.job_title_name || '';
        document.getElementById('department').value = user.department || '';
    }

    function enableEditing() {
        document.querySelectorAll('#overview input').forEach(input => {
            input.readOnly = false;
            input.classList.add('editing');
        });
    }

    function disableEditing() {
        document.querySelectorAll('#overview input').forEach(input => {
            input.readOnly = true;
            input.classList.remove('editing');
        });
        editBtn.innerHTML = '<img src="/images/edit.svg" alt="edit">Edit';
    }

    function saveUserDetails(userId) {
        const data = {
            name: document.getElementById('full-name').value,
            department: document.getElementById('department').value
        };

        fetch(`/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('User updated successfully', 'success');
                updateUserInList(data.user);
                disableEditing();
            } else {
                showNotification(data.error, 'error');
            }
        })
        .catch(error => showNotification('Failed to update user', 'error'));
    }

    function removeUser(userId) {
        fetch(`/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`[data-user-id="${userId}"]`).remove();
                clearUserDetails();
                showNotification('User removed successfully', 'success');
            } else {
                showNotification(data.error, 'error');
            }
        })
        .catch(error => showNotification('Failed to remove user', 'error'));
    }

    function clearUserDetails() {
        document.getElementById('detail-name').textContent = '';
        document.getElementById('detail-id').textContent = 'ID: ';
        document.getElementById('full-name').value = '';
        document.getElementById('job-title').value = '';
        document.getElementById('department').value = '';
        selectedUserId = null;
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notify-popup ${type}`;
        notification.innerHTML = `
            <div class="notify-invite">
                <div class="notify-content">
                    <p>${message}</p>
                    <button type="button" class="oke-btn">OK</button>
                </div>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
});
