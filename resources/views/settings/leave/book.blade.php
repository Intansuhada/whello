@extends('app')

@section('content')
@include('partials.navbar')
<div class="content">
    @include('partials.sidebar')
    <div class="wrapper-profile-content">
        <div class="breadcrumb">
            <span>Book Leave</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="{{ route('dashboard') }}">Whello</a></li>
                    <li><a href="{{ route('settings.leave.calendar') }}">Leave Calendar</a></li>
                    <li>Book Leave</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            @include('settings.leave.partials.menu')

            <div class="profile-info-wrapper">
                <div class="system-card">
                    <div class="system-card-header">
                        <div class="system-card-title">
                            <h3>Book Leave</h3>
                        </div>
                    </div>
                    <div class="system-card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('settings.leave.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label class="form-label" for="leave_type_id">Leave Type</label>
                                <select id="leave_type_id" name="leave_type_id" class="form-select" required>
                                    @foreach($leaveTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="start_date">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required min="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="end_date">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required min="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-submit">Submit Request</button>
                                <a href="{{ route('settings.leave.calendar') }}" class="btn-cancel">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #374151;
}

.form-control, .form-select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #D1D5DB;
    border-radius: 6px;
    font-size: 14px;
}

.form-control:focus, .form-select:focus {
    border-color: #2563EB;
    outline: none;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.btn-submit {
    background: #2563EB;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-submit:hover {
    background: #1D4ED8;
}

.btn-cancel {
    background: white;
    color: #374151;
    border: 1px solid #D1D5DB;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.2s;
}

.btn-cancel:hover {
    background: #F3F4F6;
}

.alert {
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.alert-danger {
    background: #FEE2E2;
    color: #991B1B;
    border: 1px solid #FCA5A5;
}

.alert-success {
    background: #DEF7EC;
    color: #03543F;
    border: 1px solid #84E1BC;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });
});
</script>
@endsection