@extends('app')

@section('content')

@include('partials.navbar')

<div class="content">

    @include('partials.sidebar')
    <div class="user-wrapper">
        <div class="user-info">
            <div class="user-invite-overview">
                <div class="user-invite">
                    {{-- Notify --}}
                    @if (session('success'))
                        <div class="alert alert-success notify-popup">
                            <div class="notify-invite">
                                <div class="notify-content">
                                    <p> {{ session('success') }} </p>
                                    <button type="button" class="oke-btn" id="oke-close">Oke</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="error notify-popup">
                            <div class="notify-invite">
                                <div class="notify-content">
                                    <p> {{ session('error') }}</p>
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
                        <div class="user-profile">
                            <img src="{{ asset('images/account.svg') }}" alt="Avatar" class="profile-img">
                            <div class="profile-info">
                                <p class="profile-name">{{ $user->name ?? $user->email }}</p>
                                <p class="profile-position">Specialist</p>
                            </div>
                        </div>
                    @endforeach
                    @if (!empty($pendingUsers))
                        <hr>
                        @foreach ($pendingUsers as $user)
                        <div class="user-profile">
                            <img src="{{ asset('images/account.svg') }}" alt="Avatar" class="profile-img">
                            <div class="profile-info">
                                <p class="profile-name">{{ $user->email }}</p>
                                <p class="profile-position">Pending invite...</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                <div class="user-overview">
                    <!-- User detail -->
                    <div class="user-detail">
                        <img src="{{ asset('images/account.svg') }}" alt="Avatar" class="detail-avatar">
                        <div class="detail-info">
                            <div class="detail-header">
                                <div class="detail-text">
                                    <input type="text" class="detail-name-input" value="Sigit Prasetio Adiguna">
                                    <div class="detail-row">
                                        <input type="text" class="detail-id-input" value="ID: 01124">
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
                                        <button class="users-rmv-btn">
                                            <img src="{{ asset('images/remove.svg') }}" alt="remove">
                                            Remove
                                        </button>
                                    </div>
                                    <div class="users-setting">
                                        <img src="{{ asset('images/setting.svg') }}" alt="setting"
                                            class="setting-icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab menu -->
                    <div class="tab-menu">
                        <a href="#" class="tablink active">Overviews</a>
                        <a href="#" class="tablink">Client</a>
                        <a href="#" class="tablink">Project</a>
                        <a href="#" class="tablink">Task</a>
                        <a href="#" class="tablink">Leave Planner</a>
                        <a href="#" class="tablink">Time Sheets</a>
                        <a href="#" class="tablink">Activities</a>
                        <a href="#" class="tablink">Access</a>
                    </div>
                    <div class="tab-content">
                        <!-- Content for each tab goes here -->
                        <div id="Overviews" class="tab-detail active">
                            <div class="overview-detail">
                                <div class="form-group">
                                    <label for="full-name">Username</label>
                                    <input type="text" id="full-name" placeholder="Sigit Prasetyo Adiguna"
                                        value="{{ $users[0]->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="employee-id">ID</label>
                                    <input type="text" id="employee-id" placeholder="01124"
                                        value="{{ $users[0]->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="position">Job Title</label>
                                    <input type="text" id="position" placeholder="Project Manager"
                                        value="Specialist">
                                </div>
                                <div class="form-group">
                                    <label for="position">Department</label>
                                    <input type="text" id="position" placeholder="Project Manager">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popup Modal -->
            <div id="invite-popup" class="invite-popup">
                <div class="popup-content">
                    <div class="header-popup-invite">
                        <h2>Invite People</h2>
                        <span class="close" id="popup-close-btn">&times;</span>
                    </div>
                    
                    <form action="{{ route('users.invite') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="invite-email">Email</label>
                            <input type="email" id="invite-email" name="email" placeholder="Enter email" required>
                        </div>
                        <button type="submit" class="send-btn">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
