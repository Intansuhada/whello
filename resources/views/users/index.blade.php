@extends('layouts.app')

@section('content')
<div class="users-container">
    <div class="users-header">
        <h1>Users</h1>
        <button class="btn-invite" id="inviteButton">Invite User</button>
    </div>

    <div class="users-list">
        @foreach($users as $user)
            <div class="user-card" data-user-id="{{ $user->id }}">
                <div class="user-avatar">
                    <img src="{{ $user->avatar_url }}" 
                         alt="{{ $user->profile?->name ?? 'User' }}" 
                         class="avatar">
                </div>
                <div class="user-info">
                    <h3>{{ $user->profile?->name ?? 'Unnamed User' }}</h3>
                    <p>{{ $user->profile?->job_title ?? 'No Job Title' }}</p>
                </div>
                <div class="user-actions">
                    <button class="btn-details" onclick="showUserDetails({{ $user->id }})">View Details</button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Keep your existing modals and scripts -->
<!-- ...existing code... -->
@endsection
