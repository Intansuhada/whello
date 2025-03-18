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

                <!-- Leave History Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>
                            Leave History Overview
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="stats-card bg-primary text-white">
                                    <div class="stats-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stats-info">
                                        <h5>Approved Leaves</h5>
                                        <h3>{{ $leavePlans->where('status', 'approved')->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card bg-warning text-white">
                                    <div class="stats-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="stats-info">
                                        <h5>Pending Leaves</h5>
                                        <h3>{{ $leavePlans->where('status', 'pending')->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card bg-danger text-white">
                                    <div class="stats-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="stats-info">
                                        <h5>Rejected Leaves</h5>
                                        <h3>{{ $leavePlans->where('status', 'rejected')->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card bg-success text-white">
                                    <div class="stats-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="stats-info">
                                        <h5>Total Leaves</h5>
                                        <h3>{{ $leavePlans->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave History Table Card -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Detailed Leave History
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
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
                                                    <span class="leave-badge {{ strtolower($leave->leaveType->name) }}">
                                                        {{ $leave->leaveType->name }}
                                                    </span>
                                                @else
                                                    <span class="leave-badge default">N/A</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ date('d M Y', strtotime($leave->start_date)) }}</td>
                                        <td>{{ date('d M Y', strtotime($leave->end_date)) }}</td>
                                        <td>
                                            <div class="description-cell" title="{{ $leave->description }}">
                                                {{ $leave->description ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-pill {{ $leave->status }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No leave history found</p>
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
    /* Card Styles */
    .card {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(16, 24, 40, 0.1);
        border: 1px solid #EAECF0;
        margin-bottom: 24px;
    }

    .card-header {
        background: #FCFCFD;
        padding: 16px 24px;
        border-bottom: 1px solid #EAECF0;
    }

    .card-title {
        color: #101828;
        font-size: 16px;
        font-weight: 600;
    }

    /* Stats Card Styles */
    .stats-card {
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stats-icon {
        font-size: 24px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
    }

    .stats-info h5 {
        font-size: 14px;
        margin: 0;
        opacity: 0.9;
    }

    .stats-info h3 {
        font-size: 24px;
        margin: 4px 0 0;
        font-weight: 600;
    }

    /* Table Styles */
    .table {
        margin: 0;
    }

    .table th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #667085;
        background-color: #F9FAFB;
        padding: 12px 24px;
    }

    .table td {
        padding: 16px 24px;
        vertical-align: middle;
    }

    /* Leave Badge Styles */
    .leave-badge {
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .leave-badge.annual { background: #EFF8FF; color: #175CD3; }
    .leave-badge.sick { background: #FEF3F2; color: #B42318; }
    .leave-badge.personal { background: #F9F5FF; color: #6941C6; }
    .leave-badge.default { background: #F2F4F7; color: #344054; }

    /* Status Pill Styles */
    .status-pill {
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-pill.approved {
        background: #ECFDF3;
        color: #027A48;
    }

    .status-pill.pending {
        background: #FFFAEB;
        color: #B54708;
    }

    .status-pill.rejected {
        background: #FEF3F2;
        color: #B42318;
    }

    /* Description Cell */
    .description-cell {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        color: #667085;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 16px;
        }
        
        .table-responsive {
            border-radius: 12px;
        }
    }
</style>
@endpush
@endsection