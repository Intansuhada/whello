@extends('settings.system')

@section('system-content')
<div class="settings-section mb-5">
    <div class="settings-section-header mb-4">
        <h2 class="settings-main-title">Add Company Holiday</h2>
    </div>

    <form action="{{ route('system.holidays.store') }}" method="POST">
        @csrf
        <div class="settings-block">
            <x-setting-card>
                <div class="settings-header">
                    <h3>Holiday Details</h3>
                </div>
                <div class="settings-body">
                    <div class="form-group mb-3">
                        <label for="name">Holiday Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </x-setting-card>
        </div>
        <div class="settings-actions">
            <button type="submit" class="btn-update">Save</button>
            <a href="{{ route('system.working-day') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
