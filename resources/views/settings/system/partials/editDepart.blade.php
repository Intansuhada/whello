@extends('settings.system')

@section('system-content')
<div class="content-detail active" id="department-edit">
    <div class="notifications-wrapper">
        <div class="settings-container">
            <div class="settings-section mb-5">
                <div class="settings-section-header mb-4">
                    <h2 class="settings-main-title">Edit Department</h2>
                </div>
                
                <x-setting-card :hasHeader="false">
                    <div class="settings-wrapper">

                            <form action="{{ route('department.updateDepart', $department->id) }}" method="POST">
               
                            @csrf
                            @method('PUT')
                            
                            <div class="settings-block mb-5">
                                <x-setting-card>
                                    <div class="settings-header card-header">
                                        <h3>Department Details</h3>
                                        <p class="text-muted">Update the department information below.</p>
                                    </div>
                                    <div class="settings-content p-4">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label fw-bold mb-2">Name</label>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name"
                                                   class="form-control custom-input @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $department->name) }}" 
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
                                                      rows="4">{{ old('description', $department->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </x-setting-card>
                            </div>

                            <div class="settings-actions">
                                <button type="submit" class="btn-update">Update Department</button>
                                
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
/* Using the same CSS as job title edit page */
.btn-delete {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    margin: 0 10px;
    cursor: pointer;
}
.btn-delete:hover {
    background-color: #c82333;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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

function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("department.destroyDepart", $department->id) }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = '{{ csrf_token() }}';
            
            form.appendChild(methodField);
            form.appendChild(csrfField);
            document.body.appendChild(form);
            
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            form.submit();
        }
    });
}

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
