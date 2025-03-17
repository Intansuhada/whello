<div class="user-tab-content">
    <div class="tab-header">
        <h2>Leave Planner</h2>
    </div>
    <div class="tab-body">
        <!-- Debug section -->
        @if(config('app.debug'))
            <div class="debug-info">
                <p>Leave Balance: {{ print_r($leaveBalance ?? 'Not set', true) }}</p>
                <p>Leaves Data: {{ print_r($leaves ?? 'Not set', true) }}</p>
            </div>
        @endif
        
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
                <table class="leave-table">
                    <thead>
                        <tr>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($leaves) && count($leaves) > 0)
                        @foreach($leaves as $leave)
                        <tr>
                            <td>{{ $leave->leave_type_id == 1 ? 'Annual Leave' : 'Sick Leave' }}</td>
                            <td>{{ $leave->start_date }}</td>
                            <td>{{ $leave->end_date }}</td>
                            <td>{{ $leave->description }}</td>
                            <td>
                                <span class="status-badge {{ $leave->status }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No leave records found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.leave-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.leave-table th,
.leave-table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

.leave-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge.approved {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.pending {
    background-color: #fff3cd;
    color: #856404;
}

.status-badge.rejected {
    background-color: #f8d7da;
    color: #721c24;
}

.text-center {
    text-align: center;
}

.tab-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.balance-details {
    display: flex;
    gap: 20px;
    margin-top: 10px;
}
</style>
