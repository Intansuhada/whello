@extends('app')

@section('content')
@include('partials.navbar')
<div class="content">
    @include('partials.sidebar')
    <div class="wrapper-profile-content">
        <div class="breadcrumb">
            <span>Leave Calendar</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="{{ route('dashboard') }}">Whello</a></li>
                    <li>Leave Calendar</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3>Leave Calendar</h3>
                        <a href="{{ route('settings.leave.book') }}" class="btn-new">
                            <i class="fas fa-plus"></i> Book Leave
                        </a>
                    </div>
                    <div class="card-content">
                        <!-- Calendar Legend -->
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <span class="legend-color weekend"></span>
                                <span>Weekend (Saturday-Sunday)</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color holiday"></span>
                                <span>National Holiday</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color approved"></span>
                                <span>Leave Approved</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color pending"></span>
                                <span>Leave Pending</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color rejected"></span>
                                <span>Leave Rejected</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color today"></span>
                                <span>Today</span>
                            </div>
                        </div>

                        <!-- Leave Stats -->
                        <div class="leave-stats">
                           
                            <div class="stat-box">
                                <div class="stat-icon approved">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>{{ $approvedLeaves ?? 0 }}</h4>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>{{ $pendingLeaves ?? 0 }}</h4>
                                    <span>Pending</span>
                                </div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-icon approved">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>{{ $rejectedLeaves ?? 0 }}</h4>
                                    <span>Rejected</span>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="calendar-container mt-4">
                            @foreach($months as $monthNum => $month)
                            <div class="month-card">
                                <div class="month-header">{{ $month['name'] }}</div>
                                <div class="days-header">
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                    <div>Sun</div>
                                </div>
                                <div class="days-grid">
                                    @php
                                        $firstDay = Carbon\Carbon::createFromDate($year, $monthNum, 1);
                                        $daysInMonth = $firstDay->daysInMonth;
                                        $firstDayOfWeek = $firstDay->dayOfWeek == 0 ? 6 : $firstDay->dayOfWeek - 1;
                                        
                                        // Previous month padding
                                        for ($i = 0; $i < $firstDayOfWeek; $i++) {
                                            echo '<div class="day empty"></div>';
                                        }
                                        
                                        // Current month days
                                        for ($day = 1; $day <= $daysInMonth; $day++) {
                                            $date = Carbon\Carbon::createFromDate($year, $monthNum, $day);
                                            $dateStr = $date->format('Y-m-d');
                                            $classes = ['day'];
                                            $tooltip = '';
                                            
                                            // Check weekends
                                            if ($date->isWeekend()) {
                                                $classes[] = 'disabled weekend';
                                                $tooltip = 'Weekend - Cannot apply for leave';
                                            }
                                            
                                            // Check company holidays
                                            if (isset($holidays[$dateStr])) {
                                                $classes[] = 'disabled holiday';
                                                $tooltip = 'Holiday: ' . $holidays[$dateStr]['name'] . "\n" . ($holidays[$dateStr]['description'] ?? '');
                                            }
                                            
                                            // Check existing leave with status
                                            if (isset($leaveDays[$dateStr])) {
                                                $classes[] = 'has-leave';
                                                $status = $leaveDays[$dateStr]['status'];
                                                $classes[] = $status; // Add status class (approved/pending)
                                                
                                                // Set tooltip based on status
                                                if ($status === 'approved') {
                                                    $tooltip = 'Leave Approved: ' . $leaveDays[$dateStr]['description'];
                                                } else if ($status === 'pending') {
                                                    $tooltip = 'Leave Pending: ' . $leaveDays[$dateStr]['description'];
                                                } else if ($status === 'rejected') {
                                                    $tooltip = 'Leave Rejected: ' . $leaveDays[$dateStr]['description'];
                                                }
                                            }
                                            
                                            if ($date->isToday()) {
                                                $classes[] = 'today';
                                            }
                                            
                                            echo '<div class="'.implode(' ', $classes).'" '.($tooltip ? 'title="'.e($tooltip).'"' : '').'>'.$day.'</div>';
                                        }
                                        
                                        // Next month padding
                                        $remainingDays = 42 - ($firstDayOfWeek + $daysInMonth);
                                        for ($i = 0; $i < $remainingDays; $i++) {
                                            echo '<div class="day empty"></div>';
                                        }
                                    @endphp
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    background: #FFFFFF;
    border: 1px solid #EAECF0;
    box-shadow: 0px 1px 3px rgba(16, 24, 40, 0.1), 0px 1px 2px rgba(16, 24, 40, 0.06);
    border-radius: 8px;
    margin-bottom: 24px;
}

.card-header {
    padding: 24px;
    border-bottom: 1px solid #EAECF0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-weight: 500;
    font-size: 18px;
    line-height: 28px;
    color: #101828;
    margin: 0;
}

.card-content {
    padding: 24px;
}

.btn-new {
    background: #2563EB;
    border: 1px solid #2563EB;
    box-shadow: 0px 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 8px;
    padding: 10px 16px;
    color: #FFFFFF;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-new:hover {
    background: #1D4ED8;
    color: #FFFFFF;
}

.leave-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.stat-box {
    background: white;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-icon.available { background: #E8F5E9; color: #2E7D32; }
.stat-icon.approved { background: #E3F2FD; color: #1976D2; }
.stat-icon.pending { background: #FFF3E0; color: #F57C00; }

.stat-info h4 {
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 4px;
    color: #1a1a1a;
}

.stat-info span {
    color: #666;
    font-size: 14px;
}

.calendar-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.month-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.month-header {
    background: #2563eb;
    color: white;
    padding: 12px;
    text-align: center;
    font-weight: 600;
}

.days-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    padding: 8px 0;
    font-size: 12px;
    font-weight: 500;
    color: #666;
    border-bottom: 1px solid #eee;
}

.days-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    padding: 8px;
    gap: 2px;
}

/* Base styles for all days */
.day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    border-radius: 4px;
    position: relative;
    cursor: default;
    background: white;
    color: #374151;
}

/* Priority order matters - from lowest to highest */
.day.empty { 
    color: #d1d5db; 
}

.day.weekend { 
    background: #E5E7EB !important;
    color: #9CA3AF !important;
    z-index: 1;
}

.day.holiday {
    background: #FECACA !important;
    color: #B91C1C !important;
    z-index: 2;
}

.day.has-leave {
    z-index: 3;
}

/* Specific leave status styles with high specificity */
.calendar-container .month-card .days-grid .day.has-leave.approved {
    background: #86EFAC !important;
    color: #166534 !important;
}

.calendar-container .month-card .days-grid .day.has-leave.pending {
    background: #FDE68A !important;
    color: #92400E !important;
}

.calendar-container .month-card .days-grid .day.has-leave.rejected {
    background: #FF4500 !important;  /* Changed to #FF4500 */
    color: #FFFFFF !important;
}

/* Enhanced tooltip */
.day[title]:hover::after {
    content: attr(title);
    position: absolute;
    bottom: calc(100% + 5px);
    left: 50%;
    transform: translateX(-50%);
    padding: 8px 12px;
    background: #1F2937;
    color: white;
    border-radius: 6px;
    font-size: 12px;
    white-space: pre-wrap;
    z-index: 10;
    min-width: 150px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Tambahkan style untuk legend */
.calendar-legend {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 24px;
    padding: 12px;
    background: #f8fafc;
    border-radius: 8px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #4b5563;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
}

.legend-color.weekend { 
    background: #E5E7EB;
    border: 1px solid #9CA3AF;
}

.legend-color.holiday { 
    background: #FECACA;  /* Merah muda lebih terang */
    border: 1px solid #EF4444;
}

.legend-color.approved { 
    background: #86EFAC;  /* Hijau segar */
    border: 1px solid #22C55E;
}

.legend-color.pending { 
    background: #FDE68A;  /* Kuning hangat */
    border: 1px solid #F59E0B;
}

/* Updated rejected color scheme */
.legend-color.rejected { 
    background: #FF4500;  /* Changed to #FF4500 */
    border: 1px solid #cc3700;  /* Darker shade for border */
}

.legend-color.today { 
    background: #93C5FD;  /* Biru muda */
    border: 1px solid #3B82F6;
}

/* Update warna status cuti */
.day.has-leave.approved { 
    background: #86EFAC !important;  /* Hijau untuk approved */
    color: #166534 !important;
    z-index: 2;
}

.day.has-leave.pending { 
    background: #FDE68A !important;  /* Kuning untuk pending */
    color: #92400E !important;
    z-index: 2;
}

.day.has-leave.rejected { 
    background: #FF4500 !important;  /* Changed to #FF4500 */
    color: #FFFFFF !important;  /* Changed to white for better contrast */
    z-index: 2;
}

/* Make sure colors have high specificity */
.calendar-container .month-card .days-grid .day.has-leave.approved {
    background: #86EFAC !important;
    color: #166534 !important;
}

.calendar-container .month-card .days-grid .day.has-leave.pending {
    background: #FDE68A !important;
    color: #92400E !important;
}

.calendar-container .month-card .days-grid .day.has-leave.rejected {
    background: #FF4500 !important;  /* Changed to #FF4500 */
    color: #FFFFFF !important;
}

/* Add pointer cursor for leave days */
.day.has-leave {
    cursor: pointer;
}

.day.has-leave.approved { 
    background: #86EFAC !important;
    color: #166534 !important;
    z-index: 2;
}

.day.has-leave.pending { 
    background: #FDE68A !important;
    color: #92400E !important;
    z-index: 2;
}

.day.has-leave.rejected { 
    background: #FF4500 !important;  /* Changed to #FF4500 */
    color: #FFFFFF !important;
    z-index: 2;
}

/* Prioritas warna */
.day.disabled {
    background: #E5E7EB !important;
    color: #9CA3AF !important;
    z-index: 1;
}

.day.holiday {
    background: #FECACA !important;
    color: #B91C1C !important;
    z-index: 1;
}

.day.today {
    outline: 2px solid #3B82F6;
    outline-offset: -2px;
    font-weight: 600;
    z-index: 3;
}

.book-leave-btn {
    background: #2563eb;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.book-leave-btn:hover {
    background: #1d4ed8;
    color: white;
}
</style>

@php
// In your calendar day rendering loop
foreach ($events as $event) {
    // Debug output
    \Log::info("Processing event:", [
        'date' => $dateStr,
        'status' => $event->status,
        'description' => $event->description
    ]);
}
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prevent clicking on disabled days
    document.querySelectorAll('.day.disabled').forEach(day => {
        day.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });
});
</script>
@endsection