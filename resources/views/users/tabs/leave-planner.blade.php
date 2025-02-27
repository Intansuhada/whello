<div class="user-tab-content">
    <div class="tab-header">
        <h2>Leave Planner</h2>
        <button class="request-leave-btn">Request Leave</button>
    </div>
    <div class="tab-body">
        <div class="leave-summary">
            <div class="leave-balance">
                <h3>Leave Balance</h3>
                <div class="balance-details">
                    <span>Annual Leave: {{ $leaveBalance->annual ?? 0 }} days</span>
                    <span>Sick Leave: {{ $leaveBalance->sick ?? 0 }} days</span>
                </div>
            </div>
            <div class="leave-history">
                <h3>Leave History</h3>
                @if(isset($leaves) && count($leaves) > 0)
                    @foreach($leaves as $leave)
                    <div class="leave-item">
                        <span class="leave-type">{{ $leave->type }}</span>
                        <span class="leave-date">{{ $leave->start_date }} - {{ $leave->end_date }}</span>
                        <span class="leave-status {{ $leave->status }}">{{ ucfirst($leave->status) }}</span>
                    </div>
                    @endforeach
                @else
                    <p>No leave history</p>
                @endif
            </div>
        </div>
    </div>
</div>
