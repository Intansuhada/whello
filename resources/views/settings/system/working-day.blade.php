@extends('settings.system')

@section('system-content')
<section class="content-detail">
    <div class="settings-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="settings-section mb-5">
            <div class="settings-section-header mb-4">
                <h2 class="settings-main-title">Working Days</h2>
            </div>

            <form id="workingDayForm" action="{{ route('system.working-day.update') }}" method="POST">
                @csrf
                <div class="settings-wrapper">
                    <!-- Working Days Configuration -->
                    <div class="settings-block mb-5">
                        <x-setting-card>
                            <div class="settings-header">
                                <h3>Working Days Configuration</h3>
                                <p class="text-muted">Set your organization's working days and hours.</p>
                            </div>
                            
                            <div class="settings-body">
                                <div class="table-responsive">
                                    <table class="table table-settings">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Day</th>
                                                <th rowspan="2">Working Day</th>
                                                <th colspan="2" class="text-center border-bottom">AM (Morning)</th>
                                                <th colspan="2" class="text-center border-bottom">PM (Afternoon)</th>
                                            </tr>
                                            <tr>
                                                <th class="time-header">Start</th>
                                                <th class="time-header">End</th>
                                                <th class="time-header">Start</th>
                                                <th class="time-header">End</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($workingDays as $day)
                                                <tr>
                                                    <td>{{ $day->day_name }}</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <select class="form-select working-day-toggle" 
                                                                    name="working_days[{{ $day->id }}][is_working_day]"
                                                                    data-day-id="{{ $day->id }}">
                                                                <option value="1" {{ $day->is_working_day == 1 ? 'selected' : '' }}>Working Day</option>
                                                                <option value="0" {{ $day->is_working_day == 0 ? 'selected' : '' }}>Off Day</option>
                                                            </select>
                                                            <input type="hidden" 
                                                                   name="working_days[{{ $day->id }}][current_status]" 
                                                                   value="{{ $day->is_working_day }}">
                                                        </div>
                                                    </td>
                                                    <td class="time-input-cell">
                                                        <input type="time" 
                                                               class="form-control time-input"
                                                               name="working_days[{{ $day->id }}][morning_start_time]"
                                                               value="{{ $day->morning_start_time }}"
                                                               {{ !$day->is_working_day ? 'disabled' : '' }}>
                                                        <span class="off-day-text" style="{{ $day->is_working_day ? 'display:none' : '' }}">Off Day</span>
                                                    </td>
                                                    <td class="time-input-cell">
                                                        <input type="time" 
                                                               class="form-control time-input"
                                                               name="working_days[{{ $day->id }}][morning_end_time]"
                                                               value="{{ $day->morning_end_time }}"
                                                               {{ !$day->is_working_day ? 'disabled' : '' }}>
                                                        <span class="off-day-text" style="{{ $day->is_working_day ? 'display:none' : '' }}">Off Day</span>
                                                    </td>
                                                    <td class="time-input-cell">
                                                        <input type="time" 
                                                               class="form-control time-input"
                                                               name="working_days[{{ $day->id }}][afternoon_start_time]"
                                                               value="{{ $day->afternoon_start_time }}"
                                                               {{ !$day->is_working_day ? 'disabled' : '' }}>
                                                        <span class="off-day-text" style="{{ $day->is_working_day ? 'display:none' : '' }}">Off Day</span>
                                                    </td>
                                                    <td class="time-input-cell">
                                                        <input type="time" 
                                                               class="form-control time-input"
                                                               name="working_days[{{ $day->id }}][afternoon_end_time]"
                                                               value="{{ $day->afternoon_end_time }}"
                                                               {{ !$day->is_working_day ? 'disabled' : '' }}>
                                                        <span class="off-day-text" style="{{ $day->is_working_day ? 'display:none' : '' }}">Off Day</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </x-setting-card>
                    </div>

                    <!-- Timezone Settings -->
                    <div class="settings-block mb-5">
                        <x-setting-card>
                            <div class="settings-header">
                                <h3>Timezone Settings</h3>
                                <p class="text-muted">Set your organization's timezone.</p>
                                @if($currentTimezone)
                                <div class="current-timezone-info">
                                    <span class="badge bg-success">Active Timezone: {{ $currentTimezone }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="settings-body">
                                <div class="form-group">
                                    <label for="timezone" class="form-label">Select Timezone</label>
                                    <select name="timezone" id="timezone" class="form-select mb-4">
                                        @foreach(timezone_identifiers_list() as $timezone)
                                            <option value="{{ $timezone }}" {{ $currentTimezone === $timezone ? 'selected' : '' }}>
                                                {{ $timezone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    @if($currentTimezone)
                                        <div class="timezone-info mt-4">
                                            <label class="form-label text-muted mb-2">Current Time Information</label>
                                            <div class="timezone-details ms-0">
                                                <p class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-clock me-2"></i>
                                                    <span>Current Time: {{ now()->timezone($currentTimezone)->format('H:i:s') }}</span>
                                                </p>
                                                <p class="mb-0 d-flex align-items-center">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    <span>Current Date: {{ now()->timezone($currentTimezone)->format('Y-m-d') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="settings-actions">
                                <button type="submit" class="btn-update">Save Changes</button>
                                <button type="button" class="btn-cancel">Cancel</button>
                            </div>
                        </x-setting-card>
                    </div>

                    <!-- Leave Types -->
                    <div class="settings-block mb-5">
                        <x-setting-card>
                            <div class="settings-header">
                                <h3>Leave Types</h3>
                                <p class="text-muted">Manage leave types for your organization.</p>
                            </div>
                            <div class="settings-body">
                                <div class="action-bar mb-4">
                                    <div class="action-bar-inner">
                                        <a href="{{ route('system.leave-types.create') }}" class="btn-add">
                                            <i class="fas fa-plus"></i>
                                            <span>Add Leave Type</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-settings leave-types-table">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="leaveTypesTable">
                                            @foreach($leaveTypes as $leaveType)
                                                <tr>
                                                    <td>{{ $leaveType->name }}</td>
                                                    <td>{{ $leaveType->description }}</td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="{{ route('system.leave-types.edit', $leaveType->id) }}" class="btn btn-sm btn-edit">
                                                                Edit
                                                            </a>
                                                            <form id="delete-leave-type-{{ $leaveType->id }}" 
                                                                  action="{{ route('system.leave-types.destroy', $leaveType->id) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-delete" onclick="return confirmDeleteLeaveType(event)">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </x-setting-card>
                    </div>

                    <!-- Company Holidays -->
                    <div class="settings-block mb-5">
                        <x-setting-card>
                            <div class="settings-header">
                                <h3>Company Holidays</h3>
                                <p class="text-muted">Manage company holidays and special events.</p>
                            </div>
                            <div class="settings-body">
                                <div class="action-bar mb-4">
                                    <div class="action-bar-inner">
                                        <a href="{{ route('system.holidays.create') }}" class="btn-add">
                                            <i class="fas fa-plus"></i>
                                            <span>Add Holiday</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-settings holidays-table">
                                        <thead>
                                            <tr>
                                                <th>Holiday Name</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="holidaysTable">
                                            @foreach($companyHolidays as $holiday)
                                                <tr>
                                                    <td>{{ $holiday->name }}</td>
                                                    <td>{{ $holiday->date->format('Y-m-d') }}</td>
                                                    <td>{{ $holiday->description }}</td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="{{ route('system.holidays.edit', $holiday->id) }}" class="btn btn-sm btn-edit">
                                                                Edit
                                                            </a>
                                                            <form id="delete-holiday-{{ $holiday->id }}"
                                                                  action="{{ route('system.holidays.destroy', $holiday->id) }}"
                                                                  method="POST" class="d-inline">
                                                                @csrf 
                                                                <button type="submit" class="btn btn-sm btn-delete" onclick="return confirmDelete(event)">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </x-setting-card>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Add leave modal function
function showAddLeaveModal() {
    Swal.fire({
        title: '<span class="text-lg font-bold text-gray-800">Add Leave Day</span>',
        html: `
            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Day</label>
                    <select id="leaveDay" class="form-select w-full rounded-md border-gray-300">
                        @foreach($workingDays as $day)
                            <option value="{{ $day->id }}">{{ $day->day_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Leave Type</label>
                    <select id="leaveType" class="form-select w-full rounded-md border-gray-300">
                        <option value="holiday">Holiday</option>
                        <option value="vacation">Vacation</option>
                        <option value="sick">Sick Leave</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Description</label>
                    <textarea id="leaveDescription" class="form-textarea w-full rounded-md border-gray-300" rows="3"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'rounded-lg shadow-xl',
            confirmButton: 'btn-update',
            cancelButton: 'btn-cancel'
        },
        buttonsStyling: false,
        preConfirm: () => {
            const dayId = document.getElementById('leaveDay').value;
            const leaveType = document.getElementById('leaveType').value;
            const description = document.getElementById('leaveDescription').value;

            if (!description) {
                Swal.showValidationMessage('Description is required');
                return false;
            }

            return { dayId, leaveType, description };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("system.working-days.add-leave") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            });
        }
    });
}

// Handle working day toggles
document.querySelectorAll('.working-day-toggle').forEach(select => {
    select.addEventListener('change', function() {
        const row = this.closest('tr');
        const timeInputs = row.querySelectorAll('input[type="time"]');
        const offDayTexts = row.querySelectorAll('.off-day-text');
        const isWorking = this.value === '1';
        
        console.log('Working day toggle changed:', {
            value: this.value,
            dayId: this.dataset.dayId,
            isWorking: isWorking
        });

        timeInputs.forEach(input => {
            input.disabled = !isWorking;
            if (!isWorking) {
                input.value = ''; // Clear time inputs when switching to Off Day
            }
            input.style.display = isWorking ? 'block' : 'none';
        });
        
        offDayTexts.forEach(text => {
            text.style.display = isWorking ? 'none' : 'block';
        });
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.working-day-toggle').forEach(select => {
        const event = new Event('change');
        select.dispatchEvent(event);
    });
});

// Form submission
document.getElementById('workingDayForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Saving...';
    
    // Get form data
    const formData = new FormData(this);
    
    // Submit the form
    this.submit();
});

// Add Holiday Modal
function showAddHolidayModal() {
    Swal.fire({
        title: '<span class="text-lg font-bold text-gray-800">Add Company Holiday</span>',
        html: `
            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Holiday Name</label>
                    <input type="text" id="holidayName" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Date</label>
                    <input type="date" id="holidayDate" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Description</label>
                    <textarea id="holidayDescription" class="form-textarea" rows="3"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'rounded-lg shadow-xl',
            confirmButton: 'btn-update',
            cancelButton: 'btn-cancel'
        },
        buttonsStyling: false,
        preConfirm: () => {
            const holidayName = document.getElementById('holidayName').value;
            const holidayDate = document.getElementById('holidayDate').value;
            const holidayDescription = document.getElementById('holidayDescription').value;

            if (!holidayName || !holidayDate) {
                Swal.showValidationMessage('Holiday name and date are required');
                return false;
            }

            return { holidayName, holidayDate, holidayDescription };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("system.working-days.add-holiday") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    <input type="date" id="holidayDate" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Description</label>
                    <textarea id="holidayDescription" class="form-textarea" rows="3"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'rounded-lg shadow-xl',
            confirmButton: 'btn-update',
            cancelButton: 'btn-cancel'
        },
        buttonsStyling: false,
        preConfirm: () => {
            const holidayName = document.getElementById('holidayName').value;
            const holidayDate = document.getElementById('holidayDate').value;
            const holidayDescription = document.getElementById('holidayDescription').value;

            if (!holidayName || !holidayDate) {
                Swal.showValidationMessage('Holiday name and date are required');
                return false;
            }

            return { holidayName, holidayDate, holidayDescription };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("system.working-days.add-holiday") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            });
        }
    });
}

// Add Leave Type Modal
function showAddLeaveTypeModal() {
    Swal.fire({
        title: '<span class="text-lg font-bold text-gray-800">Add Leave Type</span>',
        html: `
            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Leave Type Name</label>
                    <input type="text" id="leaveTypeName" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Code</label>
                    <input type="text" id="leaveTypeCode" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Description</label>
                    <textarea id="leaveTypeDescription" class="form-textarea" rows="3"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'rounded-lg shadow-xl',
            confirmButton: 'btn-update',
            cancelButton: 'btn-cancel'
        },
        buttonsStyling: false,
        preConfirm: () => {
            const leaveTypeName = document.getElementById('leaveTypeName').value;
            const leaveTypeCode = document.getElementById('leaveTypeCode').value;
            const leaveTypeDescription = document.getElementById('leaveTypeDescription').value;

            if (!leaveTypeName || !leaveTypeCode) {
                Swal.showValidationMessage('Leave type name and code are required');
                return false;
            }

            return { leaveTypeName, leaveTypeCode, leaveTypeDescription };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("system.leave-types.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            });
        }
    });
}

function deleteLeaveType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-leave-type-'+id).submit();
        }
    });
}

function deleteHoliday(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-holiday-'+id).submit();
        }
    });
}

function confirmDelete(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.closest('form').submit();
        }
    });
    return false;
}

function confirmDeleteLeaveType(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.closest('form').submit();
        }
    });
    
    return false;
}
</script>
@endpush

@push('styles')
<style>
/* Enhanced Card Styling */
.settings-block {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(226, 232, 240, 0.8);
    overflow: hidden;
}

.settings-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Enhanced Header Styling */
.settings-header {
    background: linear-gradient(to right, #f8fafc, #ffffff);
    border-bottom: 2px solid #e5e7eb;
    padding: 1.5rem 2rem;
}

.settings-header h3 {
    color: #1a56db;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.025em;
}

/* Enhanced Table Styling */
.table-settings {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.table-settings th {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.table-settings td {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.95rem;
    vertical-align: middle;
}

/* Enhanced Form Controls */
.form-select {
    padding: 0.625rem 1rem;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background-color: #fff;
    font-size: 0.95rem;
    transition: all 0.15s ease;
    width: 100%;
    max-width: 200px;
}

.form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Enhanced Time Inputs */
.time-input {
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    width: 130px;
    font-size: 0.95rem;
    text-align: center;
    background-color: #fff;
    transition: all 0.15s ease;
}

.time-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Enhanced Button Styling */
.btn-update {
    background: linear-gradient(to right, #3b82f6, #2563eb);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.95rem;
    border: none;
    transition: all 0.15s ease;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
}

.btn-update:hover {
    background: linear-gradient(to right, #2563eb, #1d4ed8);
    transform: translateY(-1px);
    box-shadow: 0 6px 8px -1px rgba(37, 99, 235, 0.1), 0 4px 6px -1px rgba(37, 99, 235, 0.06);
}

.btn-cancel {
    background: #fff;
    color: #4b5563;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.95rem;
    border: 1px solid #e5e7eb;
    transition: all 0.15s ease;
}

.btn-cancel:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

/* Enhanced Action Buttons */
.btn-edit, .btn-delete {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.15s ease;
}

.btn-edit {
    background: #ebf5ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}

.btn-edit:hover {
    background: #dbeafe;
    border-color: #93c5fd;
}

.btn-delete {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.btn-delete:hover {
    background: #fecaca;
    border-color: #fca5a5;
}

/* Enhanced Status Badge */
.badge {
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 0.875rem;
    letter-spacing: 0.025em;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.bg-success {
    background: linear-gradient(to right, #059669, #10b981);
    color: white;
}

/* Enhanced Section Layout */
.settings-body {
    padding: 2rem;
}

.settings-actions {
    padding: 1.5rem 2rem;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* Enhanced Timezone Info */
.timezone-info {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin-top: 1rem;
}

.timezone-details {
    display: grid;
    gap: 0.75rem;
}

.timezone-details p {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #4b5563;
    margin: 0;
}

.timezone-details i {
    color: #6b7280;
    width: 1.25rem;
    text-align: center;
}

/* Enhanced Alerts */
.alert {
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.alert-success {
    background: linear-gradient(to right, #def7ec, #d1fae5);
    border: 1px solid #6ee7b7;
    color: #065f46;
}

.alert-danger {
    background: linear-gradient(to right, #fee2e2, #fecaca);
    border: 1px solid #f87171;
    color: #991b1b;
}

/* Responsive Design Improvements */
@media (max-width: 768px) {
    .settings-header {
        padding: 1.25rem;
    }

    .settings-body {
        padding: 1.25rem;
    }

    .table-settings {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .form-select, .time-input {
        max-width: none;
        width: 100%;
    }
    
    .btn-update, .btn-cancel {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

<style>
/* Update these styles to match general-workspace */
.settings-section {
    margin-bottom: 3rem;
    animation: fadeIn 0.4s ease-out;
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

/* Update section header spacing */
.settings-section-header {
    position: relative;
    padding: 1rem 0.5rem 1.5rem;
    margin-bottom: 2.5rem;
    border-bottom: 2px solid #f3f4f6;
}

/* Update title color and style to match */
.settings-main-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #3182CE;
    position: relative;
    display: inline-block;
    margin-bottom: 0.5rem;
}

.settings-main-title::after {
    content: '';
    position: absolute;
    bottom: -1rem;
    left: 0;
    width: 60px;
    height: 4px;
    background: #3182CE;
    border-radius: 2px;
}

/* Add spacing between sections */
.settings-block {
    margin-bottom: 3rem; /* Increased spacing between cards */
    background: #ffffff;
    border-radius: 1rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.settings-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

/* Update card header spacing and colors */
.settings-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(to bottom, #ffffff, #f8fafc);
    border-radius: 1rem 1rem 0 0;
}

.settings-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #3182CE; /* Match blue color */
    margin-bottom: 0.5rem;
}

/* Update table styles */
.table-settings {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-settings th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    padding: 1rem;
    border-bottom: 2px solid #e5e7eb;
    text-align: left;  /* Align header text to left */
    vertical-align: middle;
}

.table-settings td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;  /* Align cell text to left */
    vertical-align: middle;
}

/* Spesifik kolom styling */
.table-settings td:first-child {
    font-weight: 500;  /* Make first column text slightly bold */
    color: #1F2937;    /* Darker text for first column */
}

.table-settings td:nth-child(2) {
    color: #4B5563;    /* Slightly lighter text for description */
}

/* Action buttons container */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-start;  /* Align buttons to left */
}

/* Working days table specific */
.table-settings input[type="time"] {
    width: 110px;
    text-align: center;
    margin: 0 auto;
}

.table-settings .form-check {
    display: flex;
    justify-content: center;
}

/* Add zebra striping */
.table-settings tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

/* Hover effect */
.table-settings tbody tr:hover {
    background-color: #f3f4f6;
}

/* Column widths for leave types table */
.table-settings.leave-types-table th:nth-child(1),
.table-settings.leave-types-table td:nth-child(1) {
    width: 25%;
}

.table-settings.leave-types-table th:nth-child(2),
.table-settings.leave-types-table td:nth-child(2) {
    width: 55%;
}

.table-settings.leave-types-table th:nth-child(3),
.table-settings.leave-types-table td:nth-child(3) {
    width: 20%;
}

/* Column widths for holidays table */
.table-settings.holidays-table th:nth-child(1),
.table-settings.holidays-table td:nth-child(1) {
    width: 25%;
}

.table-settings.holidays-table th:nth-child(2),
.table-settings.holidays-table td:nth-child(2) {
    width: 15%;
}

.table-settings.holidays-table th:nth-child(3),
.table-settings.holidays-table td:nth-child(3) {
    width: 40%;
}

.table-settings.holidays-table th:nth-child(4),
.table-settings.holidays-table td:nth-child(4) {
    width: 20%;
}

/* Add classes to tables */
.settings-block {
    margin-bottom: 2rem;
    background: #ffffff;
    border-radius: 1rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.settings-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.content-wrapper {
    padding: 24px;
}

.settings-detail {
    background: #fff;
    border-radius: 8px;
}

.content-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 8px;
}

.content-description {
    color: #6b7280;
    margin-bottom: 24px;
}

.settings-container {
    max-width: 100%;
}

.settings-header {
    padding: 16px 24px;
    border-bottom: 1px solid #e5e7eb;
}

.settings-header h3 {
    font-size: 18px;
    font-weight: 600;
}

.settings-body {
    padding: 24px;
}

.action-bar {
    display: flex;
    justify-content: flex-end;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #4f46e5;
    color: white;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}

.settings-actions {
    display: flex;
    gap: 12px;
    padding: 24px;
    border-top: 1px solid #e5e7eb;
}

.table-settings {
    width: 100%;
    border-collapse: collapse;
}

.table-settings th {
    background: #f9fafb;
    padding: 12px;
    text-align: left;
}

.table-settings td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-check-input {
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.btn-update {
    padding: 8px 16px;
    background: #4f46e5;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
}

.btn-cancel {
    padding: 8px 16px;
    background: #fff;
    color: #374151;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
}

.btn-update:hover {
    background: #4338ca;
}

.btn-cancel:hover {
    background: #f9fafb;
}

/* Modal Styles */
.swal2-popup {
    padding: 20px;
}

.swal2-title {
    margin-bottom: 16px !important;
}

.form-select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
    background-color: #fff;
}

.form-textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
    resize: vertical;
}

/* Additional styles for new sections */
.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .content-wrapper {
        padding: 16px;
    }
    
    .settings-header {
        padding: 12px 16px;
    }
    
    .settings-body {
        padding: 16px;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
}

.alert {
    margin: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
    position: relative;
}

.alert-success {
    background-color: #DEF7EC;
    color: #03543F;
    border: 1px solid #B7EBD8;
}

.alert-danger {
    background-color: #FDE8E8;
    color: #9B1C1C;
    border: 1px solid #F8B4B4;
}

.alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 1.25rem;
    background: transparent;
    border: none;
    cursor: pointer;
}

/* Update action bar styles */
.action-bar {
    display: flex;
    justify-content: flex-end;
    padding: 0 1rem 1.5rem;
    margin: -0.5rem 0 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.action-bar-inner {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Add spacing between tables and action bars */
.table-responsive {
    margin-top: 1rem;
}

/* Update settings actions to align right */
.settings-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    padding: 20px 40px;
    border-top: 1px solid #E2E8F0;
    justify-content: flex-end;  /* Change from default to flex-end */
}

/* Remove any margin-right auto if exists */
.btn-update, .btn-cancel {
    margin-right: 0;  /* Reset any right margin */
}

/* Update button styles in CSS section */
.btn-edit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    background: #EBF5FF;
    color: #2563EB;
    border: 1px solid #BFDBFE;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    font-size: 0.875rem;
}

.btn-edit:hover {
    background: #DBEAFE;
    color: #1D4ED8;
    border-color: #93C5FD;
}

.btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    background: #FEE2E2;
    color: #DC2626;
    border: 1px solid #FECACA;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.875rem;
}

.btn-delete:hover {
    background: #FEE2E2;
    color: #B91C1C;
    border-color: #FCA5A5;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

/* Update table cells padding for better alignment */
.table-settings td {
    padding: 1rem;
    vertical-align: middle;
}

/* Main title styling - match with general workspace */
.settings-main-title {
    font-size: 1.75rem;
    font-weight: 800;
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    display: inline-block;
}

.settings-main-title::after {
    content: '';
    position: absolute;
    bottom: -1rem;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    border-radius: 2px;
}

/* Update card spacing */
.settings-block {
    margin-bottom: 3rem !important; /* Increase spacing between cards */
}

/* Update section spacing */
.settings-section {
    margin-top: 2rem;
    margin-bottom: 4rem;
}

/* Update card header colors */
.settings-header h3 {
    color: #4f46e5; /* Match with general workspace */
    font-size: 1.25rem;
    font-weight: 600;
}

/* Add spacing between sections */
.settings-wrapper > div:not(:last-child) {
    margin-bottom: 3rem;
}

/* Card hover effect */
.settings-block {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.settings-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

/* Add spacing to card body */
.settings-body {
    padding: 2rem;
}

/* Update card shadow and border */
.settings-block {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 1rem;
    background: #ffffff;
}

/* Update spacing for main content area */
.content-detail {
    padding: 2rem 2.5rem; /* Add padding around entire content */
}

/* Update container spacing */
.settings-container {
    margin-left: 1.5rem;  /* Add margin to create space from left menu */
    padding: 0.5rem;      /* Add some internal padding */
}

/* Update main section spacing */
.settings-section {
    margin-top: 1.5rem;   /* Add top margin */
    margin-bottom: 3rem;  /* Increase bottom margin */
}

/* Update block spacing */
.settings-block {
    margin-bottom: 2.5rem !important;  /* Increase space between blocks */
}

/* Update wrapper spacing */
.settings-wrapper {
    margin-top: 1rem;    /* Add top margin */
    margin-bottom: 2rem; /* Add bottom margin */
}

/* Make sure settings blocks have proper spacing */
.settings-block + .settings-block {
    margin-top: 2.5rem;  /* Add space between consecutive blocks */
}

/* Update container spacing to match general-workspace */
.content-detail {
    padding: 1rem;  /* Reduced from 2rem 2.5rem */
}

.settings-container {
    margin-left: 0;  /* Remove left margin */
    padding: 0;      /* Remove padding */
}

/* Update section spacing */
.settings-section {
    margin-top: 0;    /* Remove top margin */
    margin-bottom: 2rem;  /* Reduce bottom margin */
}

/* Update block spacing */
.settings-block {
    margin-bottom: 1.5rem !important;  /* Reduce space between blocks */
}

/* Update wrapper spacing */
.settings-wrapper {
    margin-top: 0;    /* Remove top margin */
    margin-bottom: 1rem; /* Reduce bottom margin */
}

/* Update consecutive blocks spacing */
.settings-block + .settings-block {
    margin-top: 1.5rem;  /* Reduce space between consecutive blocks */
}

/* Adjust card body padding */
.settings-body {
    padding: 1.5rem;  /* Reduce padding */
}

/* Update header padding */
.settings-header {
    padding: 1rem 1.5rem;  /* Reduce padding */
}

/* Add these new styles */
.current-timezone-info {
    margin-top: 0.5rem;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.bg-success {
    background-color: #059669;
    color: white;
}

.text-muted i {
    color: #6B7280;
}

/* Add these new timezone specific styles */
.timezone-info {
    border-top: 1px solid #e5e7eb;
    padding-top: 1rem;
}

.timezone-details {
    padding: 0.5rem 0;
}

.form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.timezone-info .form-label {
    font-size: 0.875rem;
}

.timezone-details p {
    color: #6B7280;
    font-size: 0.875rem;
}

.timezone-details i {
    color: #6B7280;
    width: 20px;
}

.time-input-cell {
    position: relative;
    min-width: 120px;
}

.off-day-text {
    display: none;
    color: #6B7280;
    font-style: italic;
    text-align: center;
    width: 100%;
}

.time-input {
    width: 100%;
}
</style>
@endsection
