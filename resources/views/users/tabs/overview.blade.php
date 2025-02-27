@if(isset($user))
    <div class="user-tab-content">
        <div class="tab-content-inner">
            <div class="tab-header">
                <h2>Overview</h2>
            </div>
            <div class="tab-body">
                <!-- Overview content -->
                <div class="user-info-overview">
                    <!-- Email -->
                    <div class="info-group">
                        <label>Email</label>
                        <p>{{ $user->email ?? 'No email set' }}</p>
                    </div>
                    
                    <!-- Role -->
                    <div class="info-group">
                        <label>Role</label>
                        <p>{{ ucfirst($user->role ?? 'User') }}</p>
                    </div>

                    <!-- Status -->
                    <div class="info-group">
                        <label>Status</label>
                        <span class="status-badge {{ $user->status ?? 'active' }}">
                            {{ ucfirst($user->status ?? 'Active') }}
                        </span>
                    </div>

                    <!-- Joined Date -->
                    <div class="info-group">
                        <label>Joined Date</label>
                        <p>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="empty-state">
        <p>Select a user to view overview</p>
    </div>
@endif

<style>
.user-tab-content {
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.info-group {
    margin-bottom: 20px;
}

.info-group label {
    display: block;
    color: #64748B;
    font-size: 14px;
    margin-bottom: 4px;
}

.info-group p {
    color: #1E293B;
    font-size: 16px;
    margin: 0;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 14px;
    font-weight: 500;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.inactive {
    background: #fee2e2;
    color: #991b1b;
}
</style>
