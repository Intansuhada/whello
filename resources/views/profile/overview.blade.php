@if(isset($user) && $user)
    <div class="debug-info">
        <!-- Only show in development -->
        @if(config('app.env') === 'local')
            <pre>
                User ID: {{ $user->id ?? 'Not set' }}
                Auth check: {{ auth()->check() ? 'Yes' : 'No' }}
                Session: {{ session()->getId() }}
            </pre>
        </div>
    @endif

    Overview
    Email
    {{ $user->email ?: 'No email found' }}

    Role
    {{ $user->role ?: 'No role found' }}

    Status
    {{ $user->status ?: 'No status found' }}

    Joined Date
    {{ $user->created_at ? $user->created_at->format('F d, Y') : 'Date not found' }}
@else
    <div class="alert alert-warning">
        User data not found. Please check if:
        <ul>
            <li>You are logged in</li>
            <li>User exists in database</li>
            <li>Database connection is working</li>
        </ul>
    </div>
@endif
