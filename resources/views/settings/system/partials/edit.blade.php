@extends('settings.system')

@section('system-content')
<div class="content-detail active" id="job-title-edit">
    <div class="notifications-wrapper">
        <div class="settings-container">
            <div class="settings-section mb-5">
                <div class="settings-section-header mb-4">
                    <h2 class="settings-main-title">Edit Job Title</h2>
                </div>
                
                <x-setting-card :hasHeader="false">
                    <div class="settings-wrapper">
                        <form action="{{ route('job-titles.update', $jobTitle->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="settings-block mb-5">
                                <x-setting-card>
                                    <div class="settings-header card-header">
                                        <h3>Job Title Details</h3>
                                        <p class="text-muted">Update the job title information below.</p>
                                    </div>
                                    <div class="settings-content p-4">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label fw-bold mb-2">Name</label>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name"
                                                   class="form-control custom-input @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $jobTitle->name) }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="form-label fw-bold mb-2">Description</label>
                                            <textarea name="description" 
                                                      id="description"
                                                      class="form-control custom-textarea @error('description') is-invalid @enderror" 
                                                      rows="4">{{ old('description', $jobTitle->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </x-setting-card>
                            </div>

                            <div class="settings-actions">
                                <button type="submit" class="btn-update">Update Job Title</button>
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
/* Main Container Styling */
.content-detail {
    animation: fadeIn 0.4s ease-out;
}

.settings-section {
    background: #ffffff;
    border-radius: 1.5rem;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
    padding: 2.5rem;
    margin-bottom: 3rem;
}

/* Enhanced Title Styling */
.settings-main-title {
    font-size: 1.85rem;
    font-weight: 800;
    background: linear-gradient(135deg, #3182CE, #2C5282);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
}

.settings-main-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #3182CE, #2C5282);
    border-radius: 2px;
}

/* Form Content Styling */
.settings-content {
    background: #ffffff;
    border-radius: 1rem;
    padding: 2.5rem !important;
}

.form-group {
    margin-bottom: 2rem;
}

.form-label {
    color: #2D3748;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    display: block;
}

/* Enhanced Input Styling */
.custom-input,
.custom-textarea {
    width: 100%;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    color: #4A5568;
    background-color: #F7FAFC;
    border: 2px solid #E2E8F0;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.custom-input {
    min-width: 500px; /* Increased width */
}

.custom-textarea {
    min-height: 150px; /* Increased height */
    resize: vertical;
}

.custom-input:focus,
.custom-textarea:focus {
    background-color: #FFFFFF;
    border-color: #4299E1;
    box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.15);
    outline: none;
}

/* Card Header Enhancement */
.settings-header.card-header {
    background: linear-gradient(to right, #EBF8FF, #F7FAFC);
    border-bottom: 1px solid #E2E8F0;
    padding: 2rem;
    border-radius: 1rem 1rem 0 0;
    margin-bottom: 0;
}

.settings-header h3 {
    color: #2B6CB0;
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

/* Enhanced Button Styling */
.settings-actions {
    display: flex;
    gap: 1rem;
    padding: 2rem 0 0.5rem;
    margin-top: 2rem;
    border-top: 1px solid #E2E8F0;
}

.btn-update {
    padding: 1rem 2.5rem;
    background: linear-gradient(135deg, #4299E1, #2B6CB0);
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 180px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 6px rgba(49, 130, 206, 0.2);
}

.btn-update:hover {
    background: linear-gradient(135deg, #2B6CB0, #2C5282);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(49, 130, 206, 0.3);
}

.btn-cancel {
    padding: 1rem 2.5rem;
    background: #EDF2F7;
    color: #4A5568;
    border: 1px solid #E2E8F0;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    min-width: 180px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel:hover {
    background: #E2E8F0;
    color: #2D3748;
    transform: translateY(-2px);
}

/* Card Content Enhancement */
.settings-block {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.settings-block:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

/* Validation Styling */
.is-invalid {
    border-color: #FC8181;
}

.invalid-feedback {
    color: #E53E3E;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
    font-weight: 500;
}

/* Animation */
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .settings-section {
        padding: 1.5rem;
    }

    .custom-input {
        min-width: 100%;
    }

    .settings-actions {
        flex-direction: column;
    }

    .btn-update,
    .btn-cancel {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .settings-header.card-header {
        padding: 1.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        form.submit();
    });
});

// Show success message if exists in session
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = '{{ route("system.general-workspace") }}';
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
