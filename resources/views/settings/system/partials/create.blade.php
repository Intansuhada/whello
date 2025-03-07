@extends('settings.system')

@section('system-content')
<div class="content-detail active" id="job-title-create">
    <div class="notifications-wrapper">
        <div class="settings-container">
            <div class="settings-section mb-5">
                <div class="settings-section-header mb-4">
                    <h2 class="settings-main-title">Create New Job Title</h2>
                </div>
                
                <x-setting-card :hasHeader="false">
                    <div class="settings-wrapper">
                        <form action="{{ route('job-titles.store') }}" method="POST">
                            @csrf
                            
                            <div class="settings-block mb-5">
                                <x-setting-card>
                                    <div class="settings-header card-header">
                                        <h3>Job Title Details</h3>
                                        <p class="text-muted">Enter the job title information below.</p>
                                    </div>
                                    <div class="settings-content p-4">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label fw-bold mb-2">Name</label>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name"
                                                   class="form-control custom-input @error('name') is-invalid @enderror" 
                                                   value="{{ old('name') }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="department_id" class="form-label fw-bold mb-2">Department</label>
                                            <select name="department_id" 
                                                    id="department_id"
                                                    class="form-control custom-select @error('department_id') is-invalid @enderror" 
                                                    required>
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="form-label fw-bold mb-2">Description</label>
                                            <textarea name="description" 
                                                      id="description"
                                                      class="form-control custom-textarea @error('description') is-invalid @enderror" 
                                                      rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </x-setting-card>
                            </div>

                            <div class="settings-actions">
                                <button type="submit" class="btn-update">Create Job Title</button>
                                <a href="{{ route('system.general-workspace') }}" class="btn-cancel">Cancel</a>
                            </div>
                        </form>
                    </div>
                </x-setting-card>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Using the same CSS as edit page */
// ...existing code...
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>
@endpush
