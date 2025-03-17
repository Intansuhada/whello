@extends('app')

@section('content')
@include('partials.navbar')
<div class="content">
    @include('partials.sidebar')
    <div class="wrapper-profile-content">
        <div class="breadcrumb">
            <span>Leave History</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="{{ route('dashboard') }}">Whello</a></li>
                    <li>Leave History</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            @include('settings.leave.partials.menu')

            <div class="profile-info-wrapper">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <div class="system-card">
                    <div class="system-card-header">
                        <div class="system-card-title">
                            <h3>Leave History</h3>
                        </div>
                    </div>
                    <div class="system-card-body">
                        <div class="table-container">
                            <table class="leave-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leavePlans as $leave)
                                    <tr>
                                        <td>
                                            <div class="leave-type">
                                                @if($leave->leaveType && $leave->leaveType->name)
                                                    <span class="leave-icon {{ strtolower($leave->leaveType->name) }}">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <span class="leave-type-name">{{ $leave->leaveType->name }}</span>
                                                @else
                                                    <span class="leave-icon default">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <span class="leave-type-name">N/A</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ date('d M Y', strtotime($leave->start_date)) }}</td>
                                        <td>{{ date('d M Y', strtotime($leave->end_date)) }}</td>
                                        <td>
                                            <div class="description-cell">
                                                {{ $leave->description ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-badge {{ $leave->status }}">
                                                {{ ucfirst($leave->status) }}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="empty-row">
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="far fa-calendar-times"></i>
                                                </div>
                                                <p>No leave history found</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Card Styling */
    .system-card {
        background: #FFFFFF;
        border: 1px solid #EAECF0;
        box-shadow: 0px 1px 3px rgba(16, 24, 40, 0.1), 0px 1px 2px rgba(16, 24, 40, 0.06);
        border-radius: 12px;
        margin-bottom: 24px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .system-card:hover {
        box-shadow: 0px 4px 8px rgba(16, 24, 40, 0.15);
    }

    .system-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #EAECF0;
        background-color: #FCFCFD;
    }

    .system-card-title h3 {
        font-weight: 600;
        font-size: 18px;
        line-height: 28px;
        color: #101828;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .system-card-title h3:before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 18px;
        background: #2E90FA;
        border-radius: 4px;
        margin-right: 12px;
    }

    .system-card-body {
        padding: 0;
    }

    /* Table Container */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    /* Table Styling */
    .leave-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-family: 'Inter', sans-serif;
    }

    .leave-table thead {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .leave-table th {
        background: #F9FAFB;
        padding: 14px 24px;
        font-weight: 600;
        font-size: 12px;
        line-height: 18px;
        color: #667085;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid #EAECF0;
        white-space: nowrap;
    }

    .leave-table td {
        padding: 16px 24px;
        font-size: 14px;
        line-height: 22px;
        color: #101828;
        border-bottom: 1px solid #EAECF0;
        transition: background-color 0.2s ease;
    }

    .leave-table tbody tr {
        transition: all 0.2s ease;
    }

    .leave-table tbody tr:hover {
        background-color: #F9FAFB;
    }

    .leave-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Leave Type Column Styling */
    .leave-type {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .leave-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        color: white;
    }

    .leave-icon.annual {
        background-color: #2E90FA;
    }

    .leave-icon.sick {
        background-color: #F04438;
    }

    .leave-icon.personal {
        background-color: #7F56D9;
    }

    .leave-icon.unpaid {
        background-color: #F79009;
    }

    .leave-icon.default {
        background-color: #98A2B3;
    }

    .leave-type-name {
        font-weight: 500;
    }

    /* Description Cell */
    .description-cell {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Status Badge Styling */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 16px;
        font-size: 12px;
        line-height: 18px;
        font-weight: 500;
    }

    .status-badge.approved {
        background: #ECFDF3;
        color: #027A48;
    }

    .status-badge.approved:before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #12B76A;
        border-radius: 50%;
        margin-right: 6px;
    }

    .status-badge.pending {
        background: #FFFAEB;
        color: #B54708;
    }

    .status-badge.pending:before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #F79009;
        border-radius: 50%;
        margin-right: 6px;
    }

    .status-badge.rejected {
        background: #FEF3F2;
        color: #B42318;
    }

    .status-badge.rejected:before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #F04438;
        border-radius: 50%;
        margin-right: 6px;
    }

    /* Empty State Styling */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
        color: #667085;
    }

    .empty-icon {
        font-size: 48px;
        color: #D0D5DD;
        margin-bottom: 16px;
    }

    .empty-state p {
        font-size: 14px;
        margin: 0;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .system-card-header {
            padding: 16px;
        }

        .leave-table th,
        .leave-table td {
            padding: 12px 16px;
        }

        .description-cell {
            max-width: 150px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Optional: Add interactivity if needed
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.leave-table tbody tr:not(.empty-row)');
        
        rows.forEach(row => {
            // Show full description on hover/click for small screens
            const descCell = row.querySelector('.description-cell');
            if (descCell) {
                descCell.addEventListener('click', function() {
                    if (this.classList.contains('expanded')) {
                        this.classList.remove('expanded');
                        this.style.whiteSpace = 'nowrap';
                    } else {
                        this.classList.add('expanded');
                        this.style.whiteSpace = 'normal';
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection