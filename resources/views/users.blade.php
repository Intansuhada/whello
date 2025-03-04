@extends('app')

@section('content')
    @include('partials.navbar')
    <div class="content">
        @include('partials.sidebar')
        <div class="user-wrapper">
            <div class="user-info">
                <div class="alert-container"></div>
                <div id="alertContainer" class="mb-4" style="display: none;">
                    <div class="alert alert-dismissible fade show" role="alert">
                        <span id="alertMessage"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <div class="user-invite-overview">
                    <div class="user-invite">
                        <!-- Remove these notification popups -->
                        {{-- @if (session('success'))
                            <div class="notify-popup">...</div>
                        @elseif (session('error'))
                            <div class="notify-popup">...</div>
                        @endif --}}
                        
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
                        <div class="user-detail" id="userDetailSection" style="display: {{ isset($showUserDetail) ? 'flex' : 'none' }}">
                            <div class="detail-info">
                                <!-- User Info Header -->
                                <div class="detail-header">
                                    <div class="detail-header-left">
                                        <div class="user-detail-avatar">
                                            <img src="{{ $detailUser['avatar'] ?? '' }}" alt="Profile Photo" id="detail-avatar">
                                        </div>
                                        <div class="detail-text">
                                            <span class="detail-name" id="detail-name">{{ $detailUser['name'] ?? '' }}</span>
                                            <span class="detail-email" id="detail-id">{{ $detailUser['email'] ?? '' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-buttons">
                                        <a href="{{ route('users.edit', isset($currentUser) ? $currentUser->id : $user->id) }}" class="users-edit-btn">
                                            <img src="{{ asset('images/edit.svg') }}" alt="edit">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('users.destroy', isset($currentUser) ? $currentUser->id : $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="users-rmv-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                <img src="{{ asset('images/remove.svg') }}" alt="remove">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Form -->
                                @if(isset($showEditForm) && isset($selectedUser))
                                    <div class="edit-user-form">
                                        <div class="edit-form-header">
                                            <h3>Edit User Profile</h3>
                                        </div>
                                        <form action="{{ route('users.update', $selectedUser->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="form-group">
                                                <label for="nickname">Nickname</label>
                                                <input type="text" id="nickname" name="nickname" 
                                                    value="{{ old('nickname', $selectedUser->profile->nickname ?? '') }}" required>
                                                @error('nickname')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="department_id">Department</label>
                                                <div class="custom-select">
                                                    <input type="text" class="form-control select-display" 
                                                           value="{{ $selectedUser->profile->department->name ?? '' }}" 
                                                           readonly placeholder="Select Department">
                                                    <select id="department_id" name="department_id" class="hidden-select" required>
                                                        <option value="">Select Department</option>
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->id }}" 
                                                                {{ (old('department_id', $selectedUser->profile->department_id ?? '') == $department->id) ? 'selected' : '' }}>
                                                                {{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="select-arrow">▼</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="job_title_id">Job Title</label>
                                                <div class="custom-select">
                                                    <input type="text" class="form-control select-display" 
                                                           value="{{ $selectedUser->profile->jobTitle->name ?? '' }}" 
                                                           readonly placeholder="Select Job Title">
                                                    <select id="job_title_id" name="job_title_id" class="hidden-select" required>
                                                        <option value="">Select Job Title</option>
                                                        @foreach($jobTitles as $jobTitle)
                                                            <option value="{{ $jobTitle->id }}"
                                                                {{ (old('job_title_id', $selectedUser->profile->job_title_id ?? '') == $jobTitle->id) ? 'selected' : '' }}>
                                                                {{ $jobTitle->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="select-arrow">▼</div>
                                                </div>
                                            </div>
                                            

                                            <div class="form-actions">
                                                <button type="submit" class="btn-update">Update Profile</button>
                                                <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                @endif
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
                                <div class="tab-content-inner">
                                    <h3>User Overview</h3>
                                    <div class="overview-grid">
                                        <div class="overview-card">
                                            <div class="card-header">Total Projects</div>
                                            <div class="card-value">12</div>
                                            <div class="card-trend positive">+3 this month</div>
                                        </div>
                                        <div class="overview-card">
                                            <div class="card-header">Active Tasks</div>
                                            <div class="card-value">8</div>
                                            <div class="card-trend negative">-2 this week</div>
                                        </div>
                                        <div class="overview-card">
                                            <div class="card-header">Completed Tasks</div>
                                            <div class="card-value">45</div>
                                            <div class="card-trend positive">+15 this month</div>
                                        </div>
                                        <div class="overview-card">
                                            <div class="card-header">Hours Logged</div>
                                            <div class="card-value">164h</div>
                                            <div class="card-trend neutral">This month</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="client" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Client Assignments</h3>
                                    <div class="data-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Project</th>
                                                    <th>Status</th>
                                                    <th>Last Activity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Sample Client 1</td>
                                                    <td>Website Redesign</td>
                                                    <td><span class="status active">Active</span></td>
                                                    <td>2 hours ago</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="project" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Project List</h3>
                                    <!-- Add your project content here -->
                                    <p>User's project information</p>
                                </div>
                            </div>
                            <div id="task" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Task List</h3>
                                    <!-- Add your task content here -->
                                    <p>User's task information</p>
                                </div>
                            </div>
                            <div id="leave-planner" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Leave Planner</h3>
                                    <!-- Add your leave planner content here -->
                                    <p>User's leave planning information</p>
                                </div>
                            </div>
                            <div id="time-sheets" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Time Sheets</h3>
                                    <!-- Add your time sheets content here -->
                                    <p>User's time tracking information</p>
                                </div>
                            </div>
                            <div id="activities" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Activities</h3>
                                    <!-- Add your activities content here -->
                                    <p>User's recent activities</p>
                                </div>
                            </div>
                            <div id="access" class="tab-detail">
                                <div class="tab-content-inner">
                                    <h3>Access Management</h3>
                                    <!-- Add your access content here -->
                                    <p>User's access and permissions</p>
                                </div>
                            </div>
                        </div>
                        <div class="no-user-selected" id="noUserSelected" style="display: {{ isset($showEditForm) ? 'none' : 'flex' }}">
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

.edit-user-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #E2E8F0;
    border-radius: 4px;
}

.error {
    color: #E53E3E;
    font-size: 14px;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn-update {
    background: #4299E1;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-cancel {
    background: #E2E8F0;
    color: #4A5568;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.detail-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.detail-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-name {
    font-size: 20px;
    font-weight: 600;
    color: #2D3748;
}

.detail-email {
    font-size: 14px;
    color: #718096;
}

.edit-user-form {
    background: white;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.edit-form-header {
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #E2E8F0;
}

.edit-form-header h3 {
    font-size: 18px;
    color: #2D3748;
    font-weight: 600;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #4A5568;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-group input:focus {
    border-color: #4299E1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
}

.btn-update {
    padding: 10px 20px;
    background: #4299E1;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-cancel {
    padding: 10px 20px;
    background: #EDF2F7;
    color: #4A5568;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.2s;
}

.btn-update:hover {
    background: #3182CE;
}

.btn-cancel:hover {
    background: #E2E8F0;
}

.error {
    color: #E53E3E;
    font-size: 13px;
    margin-top: 4px;
}

.custom-select {
    position: relative;
    width: 100%;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    background-color: white;
}

.select-display {
    width: 100%;
    padding: 10px;
    border: none;
    background: transparent !important;
    cursor: pointer !important;
    font-size: 14px;
    color: #2D3748;
}

.hidden-select {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 1;
}

.select-arrow {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #718096;
    font-size: 12px;
    z-index: 0;
}

.form-group input, 
.form-group .custom-select {
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.form-group input:focus,
.form-group .custom-select:focus-within {
    border-color: #4299E1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.form-group input:hover,
.form-group .custom-select:hover {
    border-color: #CBD5E0;
}

/* Alert Styles */
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

#alertContainer {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    min-width: 300px;
    max-width: 500px;
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

.tab-content-inner {
    padding: 20px;
}

.tab-content-inner h3 {
    color: #2D3748;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 16px;
}

.tab-content-inner p {
    color: #4A5568;
    font-size: 14px;
    line-height: 1.5;
}

/* Tab Content Styling */
.tab-content-inner {
    padding: 24px;
}

.tab-content-inner h3 {
    color: #1a202c;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #e2e8f0;
}

/* Overview Grid */
.overview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 24px;
    margin-bottom: 24px;
}

.overview-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card-header {
    color: #4a5568;
    font-size: 14px;
    margin-bottom: 8px;
}

.card-value {
    color: #2d3748;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 8px;
}

.card-trend {
    font-size: 13px;
    display: flex;
    align-items: center;
}

.card-trend.positive { color: #48bb78; }
.card-trend.negative { color: #f56565; }
.card-trend.neutral { color: #718096; }

/* Data Table */
.data-table {
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

.data-table table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 500;
    text-align: left;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.data-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    color: #2d3748;
}

.status {
    display: inline-flex;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.status.active {
    background: #e6fffa;
    color: #319795;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .overview-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .data-table {
        overflow-x: auto;
    }
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
                showAlert('Please enter an email address', 'danger');
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
                    showAlert('Invitation sent successfully!', 'success');
                    invitePopup.style.display = 'none';
                    inviteForm.reset();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.error || 'Failed to send invitation', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error sending invitation', 'danger');
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

            // Update form jika ada
            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            if (usernameInput) usernameInput.value = userName;
            if (emailInput) emailInput.value = userEmail;

            // Update URL edit dan delete buttons
            const editBtn = document.querySelector('.users-edit-btn');
            const deleteForm = document.querySelector('form[action*="destroy"]');
            if (editBtn) editBtn.href = editBtn.href.replace(/\/\d+\/edit/, `/${userId}/edit`);
            if (deleteForm) deleteForm.action = deleteForm.action.replace(/\/\d+$/, `/${userId}`);

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
            
            // Show selected tab content immediately
            const targetId = this.getAttribute('data-target');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
                targetContent.style.display = 'block';
            }
        });
    });

    // Remove the loadTabContent function as it's no longer needed

    // Handle custom select displays
    document.querySelectorAll('.hidden-select').forEach(select => {
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const display = this.parentElement.querySelector('.select-display');
            display.value = selectedOption.text;
        });
    });

    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alertContainer');
        const alertElement = alertContainer.querySelector('.alert');
        const alertMessage = document.getElementById('alertMessage');

        alertMessage.innerHTML = `
            <div class="alert-content">
                <span class="alert-icon"></span>
                ${message}
            </div>
        `;
        alertElement.classList.remove('alert-success', 'alert-danger');
        alertElement.classList.add(`alert-${type}`);
        alertContainer.style.display = 'block';
        
        setTimeout(() => {
            alertElement.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => {
                alertContainer.style.display = 'none';
                alertElement.style.animation = '';
            }, 300);
        }, 3000);
    }

    // Check for session messages on page load
    @if(session('success'))
        showAlert("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showAlert("{{ session('error') }}", 'danger');
    @endif

    // Replace confirm with showAlert for delete action
    document.querySelectorAll('.users-rmv-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                this.closest('form').submit();
            }
        });
    });
});
</script>





