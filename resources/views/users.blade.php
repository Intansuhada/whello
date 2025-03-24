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
                        <div class="user-profile" 
                            data-user-id="{{ $user->id }}" 
                            data-email="{{ $user->email }}"
                            data-job-title="{{ $user->profile?->jobTitle?->name ?? 'No Position' }}"
                            data-pay-per-hour="{{ $user->profile?->pay_per_hour ?? 0 }}"
                            data-daily-capacity="{{ $user->profile?->daily_capacity ?? 0 }}">
                            
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
                        <div class="user-detail" id="userDetailSection" style="display: {{ isset($showUserDetail) && $showUserDetail ? 'flex' : 'none' }}">
                            <div class="detail-info">
                                <!-- User Info Header -->
                                <div class="detail-header">
                                    <div class="detail-header-content">
                                        <div class="detail-header-left">
                                            <div class="user-detail-avatar">
                                                <img src="{{ isset($selectedUser) ? ($selectedUser->profile && $selectedUser->profile->avatar ? Storage::url($selectedUser->profile->avatar) : asset('images/change-photo.svg')) : asset('images/change-photo.svg') }}" alt="Profile Photo" id="detail-avatar">
                                            </div>
                                            <div class="detail-text">
                                                <div class="detail-main">
                                                    <span class="detail-name" id="detail-name">{{ isset($selectedUser) ? ($selectedUser->profile ? $selectedUser->profile->name : $selectedUser->email) : '' }}</span>
                                                    <div class="detail-info-row">
                                                        <span class="detail-email" id="detail-id">{{ isset($selectedUser) ? $selectedUser->email : '' }}</span>
                                                        <span class="separator">•</span>
                                                        <span class="detail-job" id="detail-jobTitle">{{ isset($selectedUser) ? ($selectedUser->profile?->jobTitle?->name ?? 'No Position') : '' }}</span>
                                                        <span class="separator">•</span>
                                                        <span class="detail-info" id="detail-payPerHour">Rp{{ number_format(isset($selectedUser) ? ($selectedUser->profile?->pay_per_hour ?? 0) : 0, 0, ',', '.') }}/Hours</span>
                                                        <span class="separator">•</span>
                                                        <span class="detail-info" id="detail-dailyCapacity">{{ isset($selectedUser) ? ($selectedUser->profile?->daily_capacity ?? 0) : 0 }} Hours/Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                        @if(!isset($showEditForm))
                                        <div class="header-actions">
                                            <button class="header-btn edit" onclick="openEditModal()">
                                                <img src="{{ asset('images/edit.svg') }}" alt="edit">
                                                Edit
                                            </button>
                                            
                                            <form action="{{ route('users.destroy', isset($selectedUser) ? $selectedUser->id : ($user->id ?? 0)) }}" method="POST" class="inline-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="header-btn delete" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    <img src="{{ asset('images/remove.svg') }}" alt="remove">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                        @endif
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
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" 
                                                value="{{ old('name', $selectedUser->profile->name ?? '') }}" required>
                                            @error('name')
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
                
                                      <!-- Role Permission -->
                
                                      <div class="form-group">
                                        <label for="role">User Role</label>
                                        <div class="custom-select">
                                            <input type="text" class="form-control select-display" 
                                                   value="{{ ucfirst($selectedUser->role->name ?? '') }}" 
                                                   readonly placeholder="Select Role">
                                            <select id="role" name="role" class="hidden-select" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles ?? [] as $role)
                                                    <option value="{{ $role->id }}" 
                                                        {{ ($selectedUser->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="select-arrow">▼</div>
                                        </div>
                                    </div>
                                    
                
                                        <!-- Pay Per Hour -->
                                        <div class="form-group">
                                            <label for="pay_per_hour">Pay Per Hour</label>
                                            <input type="number" id="pay_per_hour" name="pay_per_hour" 
                                                value="{{ old('pay_per_hour', $selectedUser->profile->pay_per_hour ?? '') }}" 
                                                min="0" step="0.01" required>
                                            @error('pay_per_hour')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                         <!-- Daily Capacity -->
                                         <div class="form-group">
                                            <label for="daily_capacity">Daily Capacity (Hours)</label>
                                            <input type="number" id="daily_capacity" name="daily_capacity" 
                                                value="{{ old('daily_capacity', $selectedUser->profile->daily_capacity ?? '') }}" 
                                                min="0" step="0.1" required>
                                            @error('daily_capacity')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                
                
                                        <!-- Working Days Section -->
                                        <div class="form-working-day">
                                            <p><strong>Default Working Days & Hours </strong></p>
                                            <p class="text-muted">Set your regular working schedule. Choose which days are working days.</p>
                                        </div>
                
                                        <div class="working-days-container">
                                            <div class="working-days-header">
                                                <div class="header-day">Work Days</div>
                                                <div class="header-time">Working Hours</div>
                                            </div>
                
                                            @php
                                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                            @endphp
                
                                            @foreach($days as $day)
                                                @php
                                                    $workingHour = $selectedUser->workingHours->where('day', $day)->first();
                                                    $isActive = $workingHour ? $workingHour->is_active : false;
                                                @endphp
                                                
                                                <div class="working-day-row" id="row-{{ $day }}">
                                                    <div class="day-selector">
                                                        <label class="day-label">
                                                            <input type="checkbox" 
                                                                id="checkbox-{{ $day }}" 
                                                                name="working_days[{{ $day }}]" 
                                                                class="day-checkbox"
                                                                {{ $isActive ? 'checked' : '' }}
                                                                onchange="toggleWorkingHours('{{ $day }}')">
                                                            <span class="day-name">{{ ucfirst($day) }}</span>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="time-slots" id="times-{{ $day }}">
                                                        <div class="working-hours {{ $isActive ? '' : 'hidden' }}">
                                                            <div class="time-slot">
                                                                <input type="time" 
                                                                    name="morning_start[{{ $day }}]" 
                                                                    class="time-input" 
                                                                    value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->morning_start)->format('H:i') : '08:00' }}"
                                                                    {{ $isActive ? '' : 'disabled' }}>
                                                                <span>to</span>
                                                                <input type="time" 
                                                                    name="morning_end[{{ $day }}]" 
                                                                    class="time-input" 
                                                                    value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->morning_end)->format('H:i') : '12:00' }}"
                                                                    {{ $isActive ? '' : 'disabled' }}>
                                                            </div>
                                                            <div class="time-slot">
                                                                <input type="time" 
                                                                    name="afternoon_start[{{ $day }}]" 
                                                                    class="time-input" 
                                                                    value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->afternoon_start)->format('H:i') : '13:00' }}"
                                                                    {{ $isActive ? '' : 'disabled' }}>
                                                                <span>to</span>
                                                                <input type="time" 
                                                                    name="afternoon_end[{{ $day }}]" 
                                                                    class="time-input" 
                                                                    value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->afternoon_end)->format('H:i') : '17:00' }}"
                                                                    {{ $isActive ? '' : 'disabled' }}>
                                                            </div>
                                                        </div>
                                                        <div class="off-day-message {{ $isActive ? 'hidden' : '' }}">Off Day</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Form Actions -->
                                        <div class="form-actions">
                                            <div style="flex-grow: 1"></div>
                                            <button type="submit" class="btn-update" style="background: #000000; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500;">
                                                Update Profile
                                            </button>
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
                                    <div id="leavePlannerContent">
                                        <div class="loading-message">Loading leave plans...</div>
                                    </div>
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

.working-days-container {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
}

.working-days-header {
    display: flex;
    background-color: #F7FAFC;
    padding: 12px 16px;
    border-bottom: 1px solid #E2E8F0;
    font-weight: 600;
    color: #2D3748;
}

.working-days-header > div {
    flex: 1;
}

.header-day {
    flex: 2;
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
    flex: 2;
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
    display: flex;
    flex: 4;
    gap: 20px;
}

.morning-hours, 
.afternoon-hours {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.time-input {
    width: 100px;
    padding: 6px;
    border: 1px solid #E2E8F0;
    border-radius: 4px;
    font-size: 14px;
    color: #2D3748;
}

.time-input:focus {
    outline: none;
    border-color: #4299E1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.day-hours span {
    color: #718096;
    margin: 0 5px;
    white-space: nowrap;
}

.day-off {
    color: #718096;
    font-style: italic;
}
.invite-popup {
    display: none;
    position: fixed;
    top: 100%;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 9999;
    transform: translateY(-10%);
}


.popup-content {
    position: fixed;
    top: 30%;
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
    padding: 24px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.detail-header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    width: 100%;
}

.detail-header-left {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.detail-text {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-main {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-info-row {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #718096;
    font-size: 14px;
    flex-wrap: wrap;
}

.header-actions {
    display: flex;
    gap: 8px;
}

.header-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.header-btn.edit {
    color: #3182CE;
}

.header-btn.edit:hover {
    background: #EBF8FF;
}

.header-btn.delete {
    color: #E53E3E;
}

.header-btn.delete:hover {
    background: #FED7D7;
}

.inline-form {
    display: inline;
    margin: 0;
    padding: 0;
}

.edit-user-form {
    background: white;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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

/* Update the checkbox styling */
.round-checkbox {
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #CBD5E0;
    border-radius: 50%;
    margin-right: 10px;
    cursor: pointer;
    position: relative;
    vertical-align: middle;
    transition: all 0.2s ease;
}

.round-checkbox:checked {
    background-color: #4299E1;
    border-color: #4299E1;
}

.round-checkbox:checked::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background-color: white;
    border-radius: 50%;
}

.round-checkbox:hover {
    border-color: #4299E1;
}

.round-checkbox:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

/* Keep your existing working days container styles */
.working-days-container {
    // ...existing styles...
}

/* ...existing styles... */

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge.approved {
    background: #dcfce7;
    color: #16a34a;
}

.status-badge.pending {
    background: #fef3c7;
    color: #d97706;
}

.status-badge.rejected {
    background: #fee2e2;
    color: #dc2626;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.data-table th, 
.data-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.data-table th {
    background-color: #f8fafc;
    font-weight: 500;
    color: #4a5568;
}

.no-data-message {
    text-align: center;
    padding: 2rem;
    color: #64748b;
    background: #f8fafc;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

/* ...existing styles... */
.detail-info {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #718096;
    font-size: 14px;
}

.detail-separator {
    color: #CBD5E0;
}

.detail-job {
    color: inherit; /* Mengikuti warna default elemen lain */
    font-weight: normal; /* Menyamakan ketebalan dengan elemen lain */
}

.detail-info-row {
    display: flex;
    gap: 15px; /* Jarak antar elemen */
    flex-wrap: wrap; /* Jika tidak cukup ruang, elemen akan turun ke baris berikutnya */
    align-items: center; /* Agar elemen sejajar */
}

.detail-info-row span {
    white-space: nowrap; /* Mencegah teks berpindah ke baris baru */
}

// ...existing styles...

.user-profile {
    position: relative;
    padding-right: 90px; /* Make space for action buttons */
}

.action-buttons {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.user-profile:hover .action-buttons {
    opacity: 1;
}

.action-btn {
    width: 32px;
    height: 32px;
    padding: 6px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    background: transparent;
}

.action-btn img {
    width: 16px;
    height: 16px;
}

.edit-btn:hover {
    background-color: #EBF8FF;
}

.delete-btn:hover {
    background-color: #FED7D7;
}

.delete-form {
    margin: 0;
    padding: 0;
}

/* Tooltip on hover */
.action-btn[title]:hover:after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    color: white;
    background: rgba(0,0,0,0.8);
    z-index: 10;
}

.detail-info-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 8px;
}

.detail-info-row {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-actions {
    display: flex;
    gap: 8px;
    margin-top: 4px;
}

.header-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
}

.header-btn.edit {
    color: #3182CE;
}

.header-btn.edit:hover {
    background: #EBF8FF;
}

.header-btn.delete {
    color: #E53E3E;
}

.header-btn.delete:hover {
    background: #FED7D7;
}

.header-btn img {
    width: 16px;
    height: 16px;
}

.inline-form {
    display: inline;
    margin: 0;
    padding: 0;
}

.detail-header-content {
    width: 100%;
}

.detail-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding-right: 16px;
}

.info-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.header-actions {
    display: flex;
    gap: 8px;
    margin-left: auto;
}

.header-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
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
        profile.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const userName = this.querySelector('.profile-name').textContent;
            const userEmail = this.getAttribute('data-email');
            const userAvatar = this.querySelector('img').src;

            // Ambil data tambahan
            const userJobTitle = this.getAttribute('data-job-title') || 'No Position';
            const userPayPerHour = this.getAttribute('data-pay-per-hour') || '0';
            const userDailyCapacity = this.getAttribute('data-daily-capacity') || '0';

            // Update URL tanpa reload
            const baseUrl = window.location.origin + '/users';
            const newUrl = `${baseUrl}/${userId}`;
            window.history.pushState({ userId }, '', newUrl);

            // Pastikan elemen target tersedia sebelum memperbarui
            if (document.getElementById('detail-name')) {
                document.getElementById('detail-name').textContent = userName;
            }
            if (document.getElementById('detail-id')) {
                document.getElementById('detail-id').innerHTML = `•&nbsp;&nbsp;&nbsp;${userEmail}`;
            }
            if (document.getElementById('detail-avatar')) {
                document.getElementById('detail-avatar').src = userAvatar;
            }

            // Perbarui job title, pay per hour, dan daily capacity
            if (document.getElementById('detail-jobTitle')) {
                document.getElementById('detail-jobTitle').textContent = userJobTitle;
            }
            if (document.getElementById('detail-payPerHour')) {
                document.getElementById('detail-payPerHour').textContent = `Rp${parseInt(userPayPerHour).toLocaleString('id-ID')}/Hours`;
            }
            if (document.getElementById('detail-dailyCapacity')) {
                document.getElementById('detail-dailyCapacity').textContent = `${userDailyCapacity} Hours/Days`;
            }

            // Update link tab dengan ID pengguna baru
            document.querySelectorAll('.tablink').forEach(tab => {
                const oldHref = tab.getAttribute('href');
                const newHref = oldHref.replace(/\/(\d+|0)(?=[^/]*$)/, `/${userId}`);
                tab.setAttribute('href', newHref);
            });

            // Cek apakah dalam mode edit
            const isEditMode = document.querySelector('.edit-user-form') !== null;

            // Tampilkan atau sembunyikan elemen berdasarkan mode
            if (userDetailSection) userDetailSection.style.display = 'flex';
            if (tabMenuSection) tabMenuSection.style.display = isEditMode ? 'none' : 'block';
            if (tabContentSection) tabContentSection.style.display = isEditMode ? 'none' : 'block';
            if (noUserSelected) noUserSelected.style.display = 'none';

            // Tampilkan form edit jika ada
            const editForm = document.querySelector('.edit-user-form');
            if (editForm) editForm.style.display = 'block';

            // Tandai profil yang sedang aktif
            userProfiles.forEach(p => p.classList.remove('active'));
            this.classList.add('active');

            // Perbarui tombol edit dan hapus jika ada
            const editBtn = document.querySelector('.users-edit-btn');
            const deleteForm = document.querySelector('form[action*="destroy"]');
            if (editBtn) editBtn.href = editBtn.href.replace(/\/\d+\/edit/, `/${userId}/edit`);
            if (deleteForm) deleteForm.action = deleteForm.action.replace(/\/\d+$/, `/${userId}`);
        });
    });

    // Automatically trigger click for edit mode if user ID is in URL
    const urlParams = new URLSearchParams(window.location.search);
    const editUserId = urlParams.get('user_id');
    if (editUserId) {
        const userProfile = document.querySelector(`.user-profile[data-user-id="${editUserId}"]`);
        if (userProfile) {
            userProfile.click();
        }
    }

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

    // Add handler for browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.userId) {
            const userProfile = document.querySelector(`.user-profile[data-user-id="${e.state.userId}"]`);
            if (userProfile) {
                userProfile.click();
            }
        } else {
            // Handle return to base users page
            document.querySelectorAll('.user-profile').forEach(p => p.classList.remove('active'));
            document.getElementById('userDetailSection').style.display = 'none';
            document.getElementById('tabMenuSection').style.display = 'none';
            document.getElementById('tabContentSection').style.display = 'none';
            document.getElementById('noUserSelected').style.display = 'flex';
        }
    });

    // Check URL on page load for direct access to user
    const pathParts = window.location.pathname.split('/');
    const userId = pathParts[pathParts.length - 1];
    if (userId && !isNaN(userId)) {
        const userProfile = document.querySelector(`.user-profile[data-user-id="${userId}"]`);
        if (userProfile) {
            userProfile.click();
        }
    }

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

    // Add this inside your existing script tag after the tab click handler
    const leavePlannerTab = document.querySelector('[data-target="#leave-planner"]');
    if (leavePlannerTab) {
        leavePlannerTab.addEventListener('click', async function() {
            const userId = window.location.pathname.split('/').pop();
            const leavePlannerContent = document.getElementById('leavePlannerContent');
            leavePlannerContent.innerHTML = '<div class="loading-message">Loading leave plans...</div>';

            try {
                const response = await fetch(`/users/${userId}/leave-plans`);
                const data = await response.json();
                
                if (!data.success) {
                    throw new Error(data.message || 'Failed to load leave plans');
                }

                if (data.leavePlans && data.leavePlans.length > 0) {
                    let tableHtml = `
                        <table class="data-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    
                    data.leavePlans.forEach(leave => {
                        const startDate = new Date(leave.start_date).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        const endDate = new Date(leave.end_date).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        
                        tableHtml += `
                            <tr>
                                <td>${leave.leave_type}</td>
                                <td>${startDate}</td>
                                <td>${endDate}</td>
                                <td>${leave.description || '-'}</td>
                                <td><span class="status-badge ${leave.status.toLowerCase()}">${leave.status}</span></td>
                                <td>
                                    <select class="status-select" data-leave-id="${leave.id}" onchange="updateLeaveStatus(this, ${leave.id})">
                                        <option value="pending" ${leave.status === 'pending' ? 'selected' : ''}>Pending</option>
                                        <option value="approved" ${leave.status === 'approved' ? 'selected' : ''}>Approved</option>
                                        <option value="rejected" ${leave.status === 'rejected' ? 'selected' : ''}>Rejected</option>
                                    </select>
                                </td>
                            </tr>`;
                    });
                    
                    tableHtml += `
                            </tbody>
                        </table>`;
                    leavePlannerContent.innerHTML = tableHtml;
                } else {
                    leavePlannerContent.innerHTML = `
                        <div class="no-data-message">
                            No leave plans found for this user
                        </div>`;
                }
            } catch (error) {
                console.error('Error loading leave plans:', error);
                leavePlannerContent.innerHTML = `
                    <div class="error-message">
                        Failed to load leave plans. Please try again.
                    </div>`;
            }
        });
    }
});

async function updateLeaveStatus(select, leaveId) {
    try {
        const response = await fetch(`/leave-plans/${leaveId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: select.value })
        });

        const data = await response.json();
        
        if (data.success) {
            const statusBadge = select.closest('tr').querySelector('.status-badge');
            statusBadge.className = `status-badge ${select.value.toLowerCase()}`;
            statusBadge.textContent = select.value;
            showAlert('Status updated successfully', 'success');
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Failed to update status', 'danger');
        // Reset select to previous value
        select.value = select.querySelector('[selected]').value;
    }
}
</script>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit User Profile</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <!-- Move your existing edit form here -->
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <!-- Your existing form fields go here -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" 
                        value="{{ old('name', $selectedUser->profile->name ?? '') }}" required>
                    @error('name')
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

                <!-- Role Permission -->

                <div class="form-group">
                    <label for="role">User Role</label>
                    <div class="custom-select">
                        <input type="text" class="form-control select-display" 
                            value="{{ ucfirst($selectedUser->role->name ?? '') }}" 
                            readonly placeholder="Select Role">
                        <select id="role" name="role" class="hidden-select" required>
                            <option value="">Select Role</option>
                            @foreach($roles ?? [] as $role)
                                <option value="{{ $role->id }}" 
                                    {{ ($selectedUser->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="select-arrow">▼</div>
                    </div>
                </div>

                <!-- Pay Per Hour -->
                <div class="form-group">
                    <label for="pay_per_hour">Pay Per Hour</label>
                    <input type="number" id="pay_per_hour" name="pay_per_hour" 
                        value="{{ old('pay_per_hour', $selectedUser->profile->pay_per_hour ?? '') }}" 
                        min="0" step="0.01" required>
                    @error('pay_per_hour')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Daily Capacity -->
                <div class="form-group">
                    <label for="daily_capacity">Daily Capacity (Hours)</label>
                    <input type="number" id="daily_capacity" name="daily_capacity" 
                        value="{{ old('daily_capacity', $selectedUser->profile->daily_capacity ?? '') }}" 
                        min="0" step="0.1" required>
                    @error('daily_capacity')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Working Days Section -->
                <div class="form-working-day">
                    <p><strong>Default Working Days & Hours </strong></p>
                    <p class="text-muted">Set your regular working schedule. Choose which days are working days.</p>
                </div>

                <div class="working-days-container">
                    <div class="working-days-header">
                        <div class="header-day">Work Days</div>
                        <div class="header-time">Working Hours</div>
                    </div>

                    @php
                        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    @endphp

                    @foreach($days as $day)
                        @php
                            $workingHour = $selectedUser->workingHours->where('day', $day)->first();
                            $isActive = $workingHour ? $workingHour->is_active : false;
                        @endphp
                        
                        <div class="working-day-row" id="row-{{ $day }}">
                            <div class="day-selector">
                                <label class="day-label">
                                    <input type="checkbox" 
                                        id="checkbox-{{ $day }}" 
                                        name="working_days[{{ $day }}]" 
                                        class="day-checkbox"
                                        {{ $isActive ? 'checked' : '' }}
                                        onchange="toggleWorkingHours('{{ $day }}')">
                                    <span class="day-name">{{ ucfirst($day) }}</span>
                                </label>
                            </div>
                            
                            <div class="time-slots" id="times-{{ $day }}">
                                <div class="working-hours {{ $isActive ? '' : 'hidden' }}">
                                    <div class="time-slot">
                                        <input type="time" 
                                            name="morning_start[{{ $day }}]" 
                                            class="time-input" 
                                            value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->morning_start)->format('H:i') : '08:00' }}"
                                            {{ $isActive ? '' : 'disabled' }}>
                                        <span>to</span>
                                        <input type="time" 
                                            name="morning_end[{{ $day }}]" 
                                            class="time-input" 
                                            value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->morning_end)->format('H:i') : '12:00' }}"
                                            {{ $isActive ? '' : 'disabled' }}>
                                    </div>
                                    <div class="time-slot">
                                        <input type="time" 
                                            name="afternoon_start[{{ $day }}]" 
                                            class="time-input" 
                                            value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->afternoon_start)->format('H:i') : '13:00' }}"
                                            {{ $isActive ? '' : 'disabled' }}>
                                        <span>to</span>
                                        <input type="time" 
                                            name="afternoon_end[{{ $day }}]" 
                                            class="time-input" 
                                            value="{{ $workingHour ? \Carbon\Carbon::parse($workingHour->afternoon_end)->format('H:i') : '17:00' }}"
                                            {{ $isActive ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="off-day-message {{ $isActive ? 'hidden' : '' }}">Off Day</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <div style="flex-grow: 1"></div>
                    <button type="submit" class="btn-update" style="background: #000000; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500;">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        width: 70%;
        max-width: 800px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .close-modal {
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #666;
    }

    .close-modal:hover {
        color: #333;
    }

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 0 10px;
    }
</style>

<script>
    function openEditModal() {
        const modal = document.getElementById('editUserModal');
        const closeBtn = modal.querySelector('.close-modal');
        const form = document.getElementById('editUserForm');
        const userId = window.location.pathname.split('/').pop();
        
        // Update form action URL
        form.action = `/users/${userId}`;
        
        // Show modal
        modal.style.display = 'block';

        // Close modal handlers
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Initialize working hours state
        const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        days.forEach(day => {
            const checkbox = document.getElementById(`checkbox-${day}`);
            if (checkbox) {
                toggleWorkingHoursModal(day);
            }
        });
    }

    // New toggle function specifically for modal
    function toggleWorkingHoursModal(day) {
        const checkbox = document.getElementById(`checkbox-${day}`);
        const timesContainer = document.getElementById(`times-${day}`);
        const workingHours = timesContainer.querySelector('.working-hours');
        const offDayMessage = timesContainer.querySelector('.off-day-message');
        
        if (checkbox.checked) {
            workingHours.style.display = 'flex';
            offDayMessage.style.display = 'none';
            workingHours.querySelectorAll('input[type="time"]').forEach(input => {
                input.disabled = false;
            });
        } else {
            workingHours.style.display = 'none';
            offDayMessage.style.display = 'block';
            workingHours.querySelectorAll('input[type="time"]').forEach(input => {
                input.disabled = true;
            });
        }
    }

    // Update the checkbox event listeners in modal content
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('editUserModal');
        if (modal) {
            const checkboxes = modal.querySelectorAll('.day-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const day = this.id.replace('checkbox-', '');
                    toggleWorkingHoursModal(day);
                });
            });
        }
    });
</script>