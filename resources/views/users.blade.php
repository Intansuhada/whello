@extends('app')

@section('content')
    @include('partials.navbar')
    <div class="content">
        @include('partials.sidebar')
        <div class="user-wrapper">
            <div class="user-info">
                <div class="user-invite-overview">
                    <div class="user-invite">
                        @if (session('success'))
                            <div class="notify-popup">
                                <div class="notify-invite">
                                    <div class="notify-content">
                                        <p> {{ session('success') }} </p>
                                        <button type="button" class="oke-btn" id="oke-close">Oke</button>
                                    </div>
                                </div>
                            </div>
                        @elseif (session('error'))
                            <div class="notify-popup">
                                <div class="notify-invite">
                                    <div class="notify-content">
                                        <p class="error"> {{ session('error') }}</p>
                                        <button type="button" class="oke-btn" id="oke-close">Oke</button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="invite-people">
                            <button class="invite-btn" id="invite-btn">
                                <img src="{{ asset('images/user-invite.svg') }}" alt="Invite People">
                                Invite People
                            </button>
                            <div class="icons-container">
                                <img src="{{ asset('images/filter.svg') }}" alt="Filter">
                                <img src="{{ asset('images/sort.svg') }}" alt="Sort">
                                <img src="{{ asset('images/setting.svg') }}" alt="Setting">
                            </div>
                        </div>
                        <!-- <li class="userinvite-divider"></li> -->
                        <div class="search-container">
                            <input type="text" placeholder="Search Peoples" class="search-input">
                            <i class="fa fa-search search-icon"></i>
                        </div>

                        <!-- User profiles -->
                        @foreach ($users as $user)
                            <div class="user-profile" data-user-id="{{ $user->id }}" data-email="{{ $user->email }}">
                                <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : asset('images/change-photo.svg') }}" 
                                     alt="Avatar" 
                                     class="profile-img">
                                <div class="profile-info">
                                    <p class="profile-name">{{ $user->profile ? $user->profile->name : $user->email }}</p>
                                    <p class="profile-position">{{ $user->profile?->jobTitle?->name ?? 'No Position' }}</p>
                                </div>
                            </div>
                        @endforeach
                        @if (!empty($inactivatedAccounts))
                            <hr>
                            @foreach ($inactivatedAccounts as $account)
                                <div class="user-profile pending-invite">
                                    <img src="{{ asset('images/account.svg') }}" alt="Avatar" class="profile-img">
                                    <div class="profile-info">
                                        <p class="profile-name">{{ $account->email }}</p>
                                        <p class="profile-position">pending...</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="user-overview">
                        <div class="user-detail" id="userDetailSection" style="display: none">
                            <div class="detail-info">
                                <div class="detail-header">
                                    <div class="user-detail-avatar">
                                        <img src="" alt="Profile Photo" id="detail-avatar">
                                    </div>
                                    <div class="detail-text">
                                        <span class="detail-name" id="detail-name"></span>
                                        <div class="detail-row">
                                            <span class="detail-email" id="detail-id">Email:</span>
                                        </div>
                                    </div>
                                    <div class="detail-buttons">
                                        <div class="users-edit">
                                            <button class="users-edit-btn">
                                                <img src="{{ asset('images/edit.svg') }}" alt="edit">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="users-remove">
                                            <button class="users-rmv-btn" id="users-rmv-btn">
                                                <img src="{{ asset('images/remove.svg') }}" alt="remove">
                                                Remove
                                            </button>
                                        </div>
                                        <div class="users-setting">
                                            <img src="{{ asset('images/setting.svg') }}" alt="setting" class="setting-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-menu" id="tabMenuSection" style="display: none">
                            <a href="{{ route('users.overview', ['user' => $firstUser->id ?? 0]) }}" class="tablink active" data-target="#overview">Overviews</a>
                            <a href="{{ route('users.client', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#client">Client</a>
                            <a href="{{ route('users.project', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#project">Project</a>
                            <a href="{{ route('users.task', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#task">Task</a>
                            <a href="{{ route('users.leave-planner', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#leave-planner">Leave Planner</a>
                            <a href="{{ route('users.time-sheets', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#time-sheets">Time Sheets</a>
                            <a href="{{ route('users.activities', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#activities">Activities</a>
                            <a href="{{ route('users.access', ['user' => $firstUser->id ?? 0]) }}" class="tablink" data-target="#access">Access</a>
                        </div>

                        <div class="tab-content" id="tabContentSection" style="display: none">
                            <div id="overview" class="tab-detail active">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="client" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="project" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="task" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="leave-planner" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="time-sheets" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="activities" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                            <div id="access" class="tab-detail">
                                <div class="loading">Loading...</div>
                            </div>
                        </div>
                        <div class="no-user-selected" id="noUserSelected">
                            <p>Pilih user dari daftar di sebelah kiri untuk melihat detail</p>
                        </div>
                    </div>
                </div>
                        
                <!-- Popup Modal -->
                <div class="invite-popup" id="invitePopup">
                    <div class="popup-content">
                        <div class="header-popup-invite">
                            <h2>Invite People</h2>
                            <span class="close" id="popup-close-btn">&times;</span>
                        </div>

                        <form id="inviteForm">
                            @csrf
                            <div class="form-group">
                                <label for="invite-email">Email</label>
                                <input type="email" id="invite-email" name="email" placeholder="Enter email" required>
                            </div>
                            <button type="submit" class="send-btn" id="submitBtn">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
.invite-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 9999;
    transform: translateY(-10%);
}


.popup-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    min-width: 300px;
    z-index: 10000;
    margin: 0; /* Hapus margin negatif */
}


/* Additional styles can go here if needed, but we're preserving original design */
.invite-btn {
    cursor: pointer;
    border: none;
    background: transparent;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tab-content {
    background: #fff;
    border-radius: 8px;
    margin-top: 20px;
    display: none; /* Tambahkan ini */
}

.tab-detail {
    display: none;
}

.tab-detail.active {
    display: block;
}

.loading {
    padding: 24px;
    text-align: center;
    color: #718096;
}

.no-user-selected {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    margin: 20px;
    background: #F7FAFC;
    border-radius: 8px;
    text-align: center;
}

.no-user-selected p {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

.user-profile {
    cursor: pointer;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.user-profile:hover {
    background-color: #F7FAFC;
}

.user-profile.active {
    background-color: #EBF4FF;
    border-left: 3px solid #4299E1;
}

.user-detail {
    display: none; /* Secara default tersembunyi */
    align-items: flex-start;
    gap: 20px;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.tab-menu {
    display: none; /* Tambahkan ini */
    border-bottom: 1px solid #E2E8F0;
    margin-bottom: 20px;
}

.detail-info {
    flex: 1;
    margin-left: 0; /* Remove left margin since there's no avatar */
}

.detail-name {
    font-size: 18px;
    font-weight: 600;
    color: #2D3748;
    margin-bottom: 4px;
}

.detail-id {
    font-size: 14px;
    color: #718096;
}

.user-profile.pending-invite {
    cursor: default;
    opacity: 0.7;
}

.tablink {
    display: inline-block;
    padding: 12px 16px;
    color: #4A5568;
    text-decoration: none;
    margin-right: 16px;
    border-bottom: 2px solid transparent;
    transition: all 0.2s ease;
}

.tablink:hover {
    color: #2B6CB0;
}

.tablink.active {
    color: #2B6CB0;
    border-bottom-color: #2B6CB0;
}

.tab-content {
    background: #fff;
    border-radius: 8px;
    margin-top: 20px;
    padding: 20px;
}

.tab-detail {
    display: none;
}

.tab-detail.active {
    display: block;
}

.detail-buttons {
    display: flex;
    gap: 12px;
    margin-top: 12px;
}

.users-edit-btn, .users-rmv-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
}

.users-edit-btn {
    background: #EBF8FF;
    color: #3182CE;
}

.users-rmv-btn {
    background: #FED7D7;
    color: #E53E3E;
}

.users-edit-btn:hover {
    background: #BEE3F8;
}

.users-rmv-btn:hover {
    background: #FEB2B2;
}

.user-detail-avatar {
    width: 64px;
    height: 64px;
    margin-right: 16px;
}

.user-detail-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.detail-header {
    display: flex;
    align-items: center;
}
</style>

@push('scripts')
<script>
// Tunggu hingga DOM selesai dimuat
window.onload = function() {
    console.log('Window loaded'); // Debug log

    // Dapatkan elemen yang diperlukan
    const inviteBtn = document.getElementById('invite-btn');
    const invitePopup = document.getElementById('invitePopup');
    const popupCloseBtn = document.getElementById('popup-close-btn');
    
    console.log({inviteBtn, invitePopup, popupCloseBtn}); // Debug log

    // Handler untuk tombol Invite
    if(inviteBtn) {
        inviteBtn.onclick = function(e) {
            e.preventDefault();
            console.log('Invite button clicked'); // Debug log
            if(invitePopup) {
                invitePopup.style.display = 'block';
            }
        };
    }

    // Handler untuk tombol Close
    if(popupCloseBtn) {
        popupCloseBtn.onclick = function(e) {
            e.preventDefault();
            console.log('Close button clicked'); // Debug log
            if(invitePopup) {
                invitePopup.style.display = 'none';
            }
        };
    }

    // Handler untuk klik di luar popup
    document.onclick = function(e) {
        if(e.target === invitePopup) {
            invitePopup.style.display = 'none';
        }
    };

    // Handler form submit
    const inviteForm = document.getElementById('inviteForm');
    if(inviteForm) {
        inviteForm.onsubmit = async function(e) {
            e.preventDefault();
            // ...existing form submission code...
        };
    }
};
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inviteBtn = document.getElementById('invite-btn');
    const invitePopup = document.getElementById('invitePopup');
    const popupCloseBtn = document.getElementById('popup-close-btn');
    const inviteForm = document.getElementById('inviteForm');
    const userProfiles = document.querySelectorAll('.user-profile');
    const userDetailSection = document.getElementById('userDetailSection');
    const tabMenuSection = document.getElementById('tabMenuSection');
    const tabContentSection = document.getElementById('tabContentSection');
    const noUserSelected = document.getElementById('noUserSelected');

    // Show popup
    if (inviteBtn && invitePopup) {
        inviteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            invitePopup.style.display = 'block';
        });
    }

    // Hide popup
    if (popupCloseBtn && invitePopup) {
        popupCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            invitePopup.style.display = 'none';
        });
    }

    // Close popup when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === invitePopup) {
            invitePopup.style.display = 'none';
        }
    });

    // Form submission
    if (inviteForm) {
        inviteForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('invite-email');
            const submitBtn = document.getElementById('submitBtn');
            
            if (!emailInput || !emailInput.value) {
                alert('Please enter an email address');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            try {
                const response = await fetch('/users/invite', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email: emailInput.value })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Invitation sent successfully!');
                    invitePopup.style.display = 'none';
                    inviteForm.reset();
                    location.reload();
                } else {
                    alert(data.error || 'Failed to send invitation');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error sending invitation');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send';
            }
        });
    }

    // Handle user profile click
    userProfiles.forEach(profile => {
        profile.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.querySelector('.profile-name').textContent;
            const userEmail = this.getAttribute('data-email');
            const userAvatar = this.querySelector('img').src;

            // Update user detail section with email and avatar
            document.getElementById('detail-name').textContent = userName;
            document.getElementById('detail-id').textContent = `Email: ${userEmail}`;
            document.getElementById('detail-avatar').src = userAvatar;

            // Show user detail and tabs
            userDetailSection.style.display = 'flex';
            tabMenuSection.style.display = 'block';
            tabContentSection.style.display = 'block';
            noUserSelected.style.display = 'none';

            // Set active class on selected profile
            userProfiles.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Tab handling
    const tablinks = document.querySelectorAll('.tablink');
    
    tablinks.forEach(tablink => {
        tablink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            tablinks.forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Hide all tab content
            document.querySelectorAll('.tab-detail').forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            
            // Show selected tab content
            const targetId = this.getAttribute('data-target');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
                targetContent.style.display = 'block';
                
                // Load content if needed
                loadTabContent(targetId.substring(1), this.href);
            }
        });
    });

    // Function to load tab content
    async function loadTabContent(tabName, url) {
        const contentDiv = document.querySelector(`#${tabName}`);
        if (!contentDiv) return;

        try {
            const response = await fetch(url);
            const data = await response.text();
            contentDiv.innerHTML = data;
        } catch (error) {
            console.error('Error loading tab content:', error);
            contentDiv.innerHTML = '<div class="error">Failed to load content</div>';
        }
    }
});
</script>





