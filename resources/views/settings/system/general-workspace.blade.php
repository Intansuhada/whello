@extends('settings.system')

@section('system-content')
<section class="content-detail active" id="general-workspace">
    <div class="notifications-wrapper">
        <div class="settings-container">
            <form id="workspaceForm" action="{{ route('system.workspace.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- General Settings Section -->
                <div class="settings-section mb-5">
                    <div class="settings-section-header mb-4">
                        <h2 class="settings-main-title">General Settings</h2>
                    </div>
                    
                    <x-setting-card :hasHeader="false">
                        <div class="settings-wrapper">
                            <!-- Workspace Configuration -->
                            <div class="settings-block mb-5">
                                <x-setting-card>
                                    <div class="settings-header card-header">
                                        <h3>Workspace Configuration</h3>
                                        <p class="text-muted">Configure your workspace general settings.</p>
                                    </div>
                                    <div class="table-profile table-responsive">
                                        <table class="table table-settings mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 35%;" class="bg-light">Settings</th>
                                                    <th style="width: 65%;" class="bg-light">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Workspace Name</td>
                                                    <td>
                                                        <input type="text" name="workspace_name" value="{{ $workspaceSettings->workspace_name ?? '' }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Photo Profile</td>
                                                    <td>
                                                        <div class="profile-photo-container">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <div class="profile-photo-wrapper mb-3">
                                                                    <img src="{{ $workspaceSettings && $workspaceSettings->photo_profile 
                                                                          ? Storage::url($workspaceSettings->photo_profile) 
                                                                          : asset('images/image-company-logo.svg') }}" 
                                                                         alt="Company Logo" 
                                                                         id="companyLogoPreview"
                                                                         class="profile-photo">
                                                                    <input type="file" 
                                                                           id="company-logo-input" 
                                                                           name="logo" 
                                                                           class="hidden" 
                                                                           accept="image/*"
                                                                           onchange="previewImage(this)">
                                                                </div>
                                                                <div class="photo-actions d-flex gap-2">
                                                                    <button type="button" class="btn btn-sm btn-primary" onclick="document.getElementById('company-logo-input').click()">
                                                                        Upload
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-danger" id="deleteLogoBtn" onclick="deleteLogo()">
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>
                                                        <textarea name="description" class="form-control" rows="3">{{ $workspaceSettings->description ?? '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>URL / Slug</td>
                                                    <td>
                                                        <input type="text" name="url_slug" value="{{ $workspaceSettings->url_slug ?? '' }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Owner</td>
                                                    <td>
                                                        <input type="email" name="owner_email" value="{{ $workspaceSettings->owner_email ?? '' }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Team Members</td>
                                                    <td>
                                                        <input type="number" 
                                                               name="team_members" 
                                                               value="{{ $userCount }}" 
                                                               class="form-control" 
                                                               readonly 
                                                               title="This is automatically calculated from total users">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </x-setting-card>
                            </div>

                            <!-- Regional Settings -->
                            <div class="settings-block mb-5">
                                <x-setting-card>
                                    <div class="settings-header card-header">
                                        <h3>Regional Settings</h3>
                                        <p class="text-muted">Configure your workspace regional preferences.</p>
                                    </div>
                                    <div class="table-profile table-responsive">
                                        <table class="table table-settings mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 35%;" class="bg-light">Settings</th>
                                                    <th style="width: 65%;" class="bg-light">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Time Zone</td>
                                                    <td>
                                                        <select name="timezone" class="form-control">
                                                            <option value="UTC+07:00" {{ ($workspaceSettings->timezone ?? '') == 'UTC+07:00' ? 'selected' : '' }}>Bangkok, Hanoi, Jakarta (UTC+07:00)</option>
                                                            <!-- Add more timezone options as needed -->
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Time Format</td>
                                                    <td>
                                                        <select name="time_format" class="form-control">
                                                            <option value="12" {{ ($workspaceSettings->time_format ?? '') == '12' ? 'selected' : '' }}>12 Hour Day</option>
                                                            <option value="24" {{ ($workspaceSettings->time_format ?? '') == '24' ? 'selected' : '' }}>24 Hour Day</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Default Language</td>
                                                    <td>
                                                        <select name="default_language" class="form-control">
                                                            <option value="en" {{ ($workspaceSettings->default_language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                                            <!-- Add more language options -->
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Default Currency</td>
                                                    <td>
                                                        <select name="default_currency" class="form-control">
                                                            <option value="IDR" {{ ($workspaceSettings->default_currency ?? '') == 'IDR' ? 'selected' : '' }}>Indonesia - IDR / Rupiah</option>
                                                            <!-- Add more currency options -->
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Default Company Hourly Rate</td>
                                                    <td>
                                                        <input type="text" name="default_hourly_rate" value="{{ $workspaceSettings->default_hourly_rate ?? '' }}" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </x-setting-card>
                            </div>

                            <!-- Form Actions -->
                            <div class="settings-actions">
                                <button type="submit" class="btn-update">
                                    Update Settings
                                </button>
                                <a href="{{ route('settings.system') }}" class="btn-cancel">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </x-setting-card>
                </div>
            </form>

            <!-- Replace the existing Job Titles Section with this -->
            <div class="settings-section mb-5">
                <div class="settings-section-header mb-4">
                    <h2 class="settings-main-title">Job Titles</h2>
                </div>
                <x-setting-card :hasHeader="false">
                    <div class="settings-block mb-5">
                        <x-setting-card>
                            <div class="settings-header card-header">
                                <h3>Job Title Management</h3>
                                <p class="text-muted">Manage job titles in your organization</p>
                            </div>
                            <div class="table-profile table-responsive">
                                <div class="action-bar mb-4">
                                    <a href="{{ route('job-titles.create') }}" class="btn-add">
                                        <span>Add Job Title</span>
                                    </a>
                                </div>
                                <table class="table table-settings mb-0 job-titles-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%;" class="bg-light">Job Title</th>
                                            <th style="width: 50%;" class="bg-light">Description</th>
                                            <th style="width: 15%;" class="bg-light">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jobTitles as $job)
                                            <tr>
                                                <td>{{ $job->name }}</td>
                                                <td>{{ $job->description ?? 'No description available' }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('job-titles.edit', $job->id) }}" class="btn btn-sm btn-edit">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('job-titles.destroy', $job->id) }}" method="POST" class="d-inline" 
                                                              onsubmit="return confirmDelete(event)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No job titles found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </x-setting-card>
                    </div>
                </x-setting-card>
            </div>

            <!-- Replace the existing Departments Section with this -->
            <div class="settings-section mb-5">
                <div class="settings-section-header mb-4">
                    <h2 class="settings-main-title">Departments</h2>
                </div>
                <x-setting-card :hasHeader="false">
                    <div class="settings-block mb-5">
                        <x-setting-card>
                            <div class="settings-header card-header">
                                <h3>Department Management</h3>
                                <p class="text-muted">Manage departments in your organization</p>
                            </div>
                            <div class="table-profile table-responsive">
                                <div class="action-bar mb-4">
                                    <a href="{{ route('department.createDepart') }}" class="btn-add">
                                        <span>Add Department</span>
                                    </a>
                                </div>
                                <table class="table table-settings mb-0 departments-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%;" class="bg-light">Department Name</th>
                                            <th style="width: 50%;" class="bg-light">Description</th>
                                            <th style="width: 15%;" class="bg-light">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($departments as $department)
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $department->description ?? 'No description available' }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('department.editDepart', $department->id) }}" class="btn btn-sm btn-edit">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('department.destroyDepart', $department->id) }}" method="POST" class="d-inline" 
                                                              onsubmit="return confirmDelete(event)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No departments found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </x-setting-card>
                    </div>
                </x-setting-card>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('workspaceForm');
    const alertContainer = document.getElementById('alertContainer');
    const alertElement = alertContainer.querySelector('.alert');
    const alertMessage = document.getElementById('alertMessage');
    const companyLogoInput = document.getElementById('company-logo-input');
    const companyLogoPreview = document.getElementById('companyLogoPreview');
    const deleteLogoBtn = document.getElementById('deleteLogoBtn');

    // Alert handling function
    function showSuccessAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: 1500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-lg shadow-xl'
            }
        });
    }

    // Handle logo preview
    companyLogoInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                companyLogoPreview.src = e.target.result;
                deleteLogoBtn.disabled = false;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                showSuccessAlert(result.message || 'Settings updated successfully');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: result.message || 'Failed to update settings',
                    customClass: {
                        popup: 'rounded-lg shadow-xl'
                    }
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to save changes',
                customClass: {
                    popup: 'rounded-lg shadow-xl'
                }
            });
        }
    });

    // Handle logo deletion
    deleteLogoBtn.addEventListener('click', async function() {
        if (!confirm('Are you sure you want to delete the company logo?')) {
            return;
        }

        try {
            const response = await fetch('{{ route("system.delete-company-logo") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                companyLogoPreview.src = '{{ asset("images/image-company-logo.svg") }}';
                showSuccessAlert(result.message);
                this.disabled = true;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: result.message,
                    customClass: {
                        popup: 'rounded-lg shadow-xl'
                    }
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to delete company logo',
                customClass: {
                    popup: 'rounded-lg shadow-xl'
                }
            });
        }
    });
});

// Make sure all JavaScript runs after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add button click handlers
    const addJobTitleBtn = document.querySelector('.btn-add[onclick="showAddJobTitleModal()"]');
    const addDepartmentBtn = document.querySelector('.btn-add[onclick="showAddDepartmentModal()"]');

    // Job Title Add Button
    if (addJobTitleBtn) {
        addJobTitleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showAddJobTitleModal();
        });
    }

    // Department Add Button
    if (addDepartmentBtn) {
        addDepartmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showAddDepartmentModal();
        });
    }

    // Edit buttons
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.closest('tr').querySelector('td:first-child').textContent;
            const description = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            
            if (this.closest('table').classList.contains('job-titles-table')) {
                editJobTitle(id, name, description);
            } else {
                editDepartment(id, name, description);
            }
        });
    });

    // Delete buttons
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            
            if (this.closest('table').classList.contains('job-titles-table')) {
                deleteJobTitle(id);
            } else {
                deleteDepartment(id);
            }
        });
    });
});

// Function to edit job title
function editJobTitle(id, name, description) {
    Swal.fire({
        title: '<span class="text-lg font-bold text-gray-800">Edit Job Title</span>',
        html: `
            <div class="p-2">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Name</label>
                    <input type="text" id="name" class="form-input block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="${name}">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Description</label>
                    <textarea id="description" class="form-textarea block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" rows="4">${description || ''}</textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'rounded-lg shadow-xl',
            confirmButton: 'bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-md mr-2 focus:outline-none focus:ring-2 focus:ring-blue-300',
            cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300',
            input: 'rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50',
            actions: 'border-t border-gray-100 px-6 py-3',
            header: 'border-b border-gray-100 px-6 py-4'
        },
        buttonsStyling: false,
        preConfirm: () => {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            
            if (!name) {
                Swal.showValidationMessage('Job title name is required');
                return false;
            }
            
            return { name, description };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/job-titles/${id}`, {
                method: 'PUT',
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
                        text: 'Job title updated successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-lg shadow-xl',
                        }
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
}

// Function to edit department
function editDepartment(id, name, description) {
    Swal.fire({
        title: 'Edit Department',
        html: `
            <input id="departmentName" class="swal2-input" value="${name}">
            <textarea id="departmentDescription" class="swal2-textarea">${description}</textarea>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        focusConfirm: false,
        preConfirm: () => {
            return {
                name: document.getElementById('departmentName').value,
                description: document.getElementById('departmentDescription').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/departments/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', data.message, 'success');
                    location.reload();
                }
            });
        }
    });
}

// Function to delete job title
function deleteJobTitle(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/job-titles/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success');
                    location.reload();
                }
            });
        }
    });
}

// Function to delete department
function deleteDepartment(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/departments/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success');
                    location.reload();
                }
            });
        }
    });
}

// Add these functions after your existing JavaScript code
function showAddJobTitleModal() {
    Swal.fire({
        title: '<span class="text-lg font-bold text-gray-800">Add New Job Title</span>',
        html: `
            <div class="p-2">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Name</label>
                    <input type="text" id="name" class="form-input block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Enter job title name">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 text-left mb-2">Description</label>
                    <textarea id="description" class="form-textarea block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" rows="4" placeholder="Enter description"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'rounded-lg shadow-xl',
            confirmButton: 'bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-md mr-2 focus:outline-none focus:ring-2 focus:ring-blue-300',
            cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300'
        },
        buttonsStyling: false,
        preConfirm: () => {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            
            if (!name) {
                Swal.showValidationMessage('Job title name is required');
                return false;
            }
            
            return { name, description };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("job-titles.store") }}', {
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
                        text: 'Job title added successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-lg shadow-xl'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to add job title',
                        customClass: {
                            popup: 'rounded-lg shadow-xl'
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while adding the job title',
                    customClass: {
                        popup: 'rounded-lg shadow-xl'
                    }
                });
            });
        }
    });
}

function showAddDepartmentModal() {
    Swal.fire({
        title: 'Add New Department',
        html: `
            <input id="departmentName" class="swal2-input" placeholder="Enter department name">
            <textarea id="departmentDescription" class="swal2-textarea" placeholder="Enter description"></textarea>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const name = document.getElementById('departmentName').value;
            const description = document.getElementById('departmentDescription').value;
            
            if (!name) {
                Swal.showValidationMessage('Department name is required');
                return false;
            }
            
            return { name, description };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send data to server
            fetch('{{ route("departments.store") }}', {
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
                    Swal.fire('Success', 'Department added successfully', 'success')
                    .then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', 'Failed to add department', 'error');
                }
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Event delegation untuk tombol Add Job Title
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-add-job-title')) {
            e.preventDefault();
            showAddJobTitleModal();
        }
    });

    // Event delegation untuk tombol Add Department
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-add-department')) {
            e.preventDefault();
            showAddDepartmentModal();
        }
    });

    // Event delegation untuk tombol Edit
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-edit')) {
            e.preventDefault();
            const button = e.target; // Dapatkan tombol yang diklik
            const id = button.dataset.id; // Ambil ID dari dataset
            const row = button.closest('tr'); // Cari elemen baris (tr)
            const name = row.querySelector('td:nth-child(1)').textContent.trim();
            const description = row.querySelector('td:nth-child(2)').textContent.trim();

            if (button.closest('table').classList.contains('job-titles-table')) {
                editJobTitle(id, name, description);
            } else {
                editDepartment(id, name, description);
            }
        }
    });

    // Event delegation untuk tombol Delete
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-delete')) {
            e.preventDefault();
            const button = e.target; // Dapatkan tombol yang diklik
            const id = button.dataset.id; // Ambil ID dari dataset

            if (button.closest('table').classList.contains('job-titles-table')) {
                deleteJobTitle(id);
            } else {
                deleteDepartment(id);
            }
        }
    });
});

// Update the form submission for edit
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (this.method === 'POST' && this.action.includes('update')) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            this.submit();
        }
    });
});

// Function to confirm delete
function confirmDelete(e) {
    e.preventDefault();
    const form = e.target;
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    
    return false;
}

// Show alert messages from session
@if(session('success'))
    showSuccessAlert('{{ session('success') }}');
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        customClass: {
            popup: 'rounded-lg shadow-xl'
        }
    });
@endif

// Add this CSS for better styling
const style = document.createElement('style');
style.textContent = `
    .swal2-popup {
        border-radius: 1rem !important;
    }
    .swal2-title {
        color: #2D3748 !important;
        font-size: 1.5rem !important;
        padding: 1rem 0 !important;
    }
    .swal2-html-container {
        margin: 0 !important;
    }
    .form-input, .form-textarea {
        width: 100%;
        transition: all 0.2s;
    }
    .form-input:focus, .form-textarea:focus {
        border-color: #4299E1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
    }
`;
document.head.appendChild(style);

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Update both logos
            document.getElementById('companyLogoPreview').src = e.target.result;
            document.getElementById('navbarLogo').src = e.target.result;
            document.getElementById('deleteLogoBtn').disabled = false;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteLogo() {
    Swal.fire({
        title: 'Delete Logo',
        text: "Are you sure you want to delete this logo?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("system.delete-company-logo") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset images to defaults
                    document.getElementById('companyLogoPreview').src = '{{ asset("images/image-company-logo.svg") }}';
                    document.getElementById('navbarLogo').src = '{{ asset("images/whello-logo.svg") }}';
                    document.getElementById('company-logo-input').value = '';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Logo deleted successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to delete logo'
                });
            });
        }
    });
}

// Add this function to toggle between view and edit modes
function toggleEditMode() {
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    
    if (viewMode.style.display !== 'none') {
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
    } else {
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
    }
}
</script>
@endpush

<style>
/* Enhanced Base Styles */
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
    padding: 1rem 0.5rem 1.5rem; /* Increased padding top and bottom */
    margin-bottom: 2.5rem; /* Increased margin bottom */
    border-bottom: 2px solid #f3f4f6;
}

.settings-main-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #3182CE; /* Changed to blue */
    position: relative;
    display: inline-block;
    margin-bottom: 0.5rem; /* Add margin bottom to title */
}

.settings-main-title::after {
    content: '';
    position: absolute;
    bottom: -1rem;
    left: 0;
    width: 60px;
    height: 4px;
    background: #3182CE; /* Changed to match title color */
    border-radius: 2px;
}

/* Add spacing between sections */
.settings-block {
    margin-top: 2rem; /* Add top margin */
    margin-bottom: 3rem; /* Increase bottom margin */
    // ...existing styles...
}

/* Update card header spacing */
.settings-header.card-header {
    padding: 2rem 1.5rem; /* Increase padding */
    margin-bottom: 1.5rem; /* Add margin bottom */
    // ...existing styles...
}

/* Add spacing for settings wrapper */
.settings-wrapper {
    padding-top: 1.5rem; /* Add padding top */
    // ...existing styles...
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.settings-section-header {
    position: relative;
    padding: 0 0.5rem 1rem;
    margin-bottom: 2rem;
    border-bottom: 2px solid #f3f4f6;
}

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

/* Enhanced Card Styles */
.settings-wrapper {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
    width: 100%; /* Add this */
    max-width: 100%; /* Add this */
}

.settings-block {
    background: #ffffff;
    border-radius: 1rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
    width: 100%; /* Add this */
    max-width: 100%; /* Add this */
}

.settings-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

/* Enhanced Table Styles */
.table-settings {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed; /* Add this */
}

.table-settings th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    padding: 1.25rem 1.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.table-settings td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.2s ease;
    width: 100%; /* Add this */
}

.table-settings tr:hover td {
    background-color: #f9fafb;
}

.table-settings td:first-child {
    width: 35%; /* Add this */
    white-space: nowrap; /* Add this */
}

.table-settings td:last-child {
    width: 65%; /* Add this */
}

/* Enhanced Form Controls */
.form-control {
    width: 100%; /* Add this */
    max-width: 100%; /* Add this */
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background-color: #f9fafb;
}

.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    background-color: #ffffff;
}

/* Enhanced Select Styles */
select.form-control {
    cursor: pointer;
    background-color: #f9fafb;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.25rem;
    padding-right: 2.5rem;
    appearance: none;
}

/* Enhanced Button Styles */
.settings-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    padding: 20px 40px;  /* Increased horizontal padding */
    border-top: 1px solid #E2E8F0;
    justify-content: flex-end; /* Add this */
}

.btn-update {
    padding: 12px 24px;
    background: linear-gradient(to right, #3182CE, #2C5282);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2);
    min-width: 140px;
    text-align: center;
}

.btn-update:hover {
    background: linear-gradient(to right, #2C5282, #3182CE);
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(49, 130, 206, 0.3);
}

.btn-cancel {
    padding: 12px 24px;
    background: #EDF2F7;
    color: #4A5568;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    min-width: 140px;
}

.btn-cancel:hover {
    background: #E2E8F0;
    color: #2D3748;
}

/* Action Buttons (Edit/Delete) */
.btn-icon {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 80px;
    text-align: center;
}

.btn-edit {
    background: #EBF8FF;
    color: #3182CE;
    border: 1px solid #BEE3F8;
}

.btn-edit:hover {
    background: #BEE3F8;
    color: #2C5282;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(49, 130, 206, 0.15);
}

.btn-delete {
    background: #FED7D7;
    color: #E53E3E;
    border: 1px solid #FEB2B2;
}

.btn-delete:hover {
    background: #FEB2B2;
    color: #C53030;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(229, 62, 62, 0.15);
}

/* Add Job/Department Button */
.btn-add {
    padding: 10px 24px;
    background: #4299E1;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
    box-shadow: 0 2px 4px rgba(66, 153, 225, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-add:hover {
    background: #3182CE;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(66, 153, 225, 0.3);
}

.btn-add::before {
    content: '+';
    font-size: 18px;
    font-weight: 400;
}

/* Upload/Delete Photo Buttons */
.photo-actions .btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    min-width: 90px;
    text-align: center;
}

.photo-actions .btn-secondary {
    background: #EDF2F7;
    color: #4A5568;
    border: 1px solid #E2E8F0;
}

.photo-actions .btn-secondary:hover {
    background: #E2E8F0;
    color: #2D3748;
}

.photo-actions .btn-danger {
    background: #FED7D7;
    color: #E53E3E;
    border: 1px solid #FEB2B2;
}

.photo-actions .btn-danger:hover {
    background: #FEB2B2;
    color: #C53030;
    transform: translateY(-1px);
}

/* Action buttons container */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

/* Enhanced Photo Upload Styles */
.profile-photo-container {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.profile-photo-wrapper {
    width: 100px;
    height: 100px;
    border-radius: 1rem;
    border: 3px solid #e5e7eb;
    overflow: hidden;
    background: #f7fafc;
    position: relative;
    transition: all 0.3s ease;
}

.profile-photo-wrapper:hover {
    border-color: #4f46e5;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
}

.profile-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.profile-photo-wrapper:hover .profile-photo {
    transform: scale(1.05);
}

.photo-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.photo-actions .btn {
    padding: 0.625rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.photo-actions .btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.photo-actions .btn-secondary:hover {
    background: #e5e7eb;
    color: #1f2937;
}

.photo-actions .btn-danger {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.photo-actions .btn-danger:hover {
    background: #fecaca;
    color: #b91c1c;
}

/* Enhanced Card Header */
.settings-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(to bottom, #ffffff, #f8fafc);
    border-radius: 1rem 1rem 0 0;
}

.settings-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #3182CE; /* Changed to blue */
    margin-bottom: 0.5rem;
}

.settings-header p {
    font-size: 0.95rem;
    color: #6b7280;
    margin: 0;
}

/* Animation Effects */
@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.settings-block {
    animation: slideIn 0.4s ease-out forwards;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .settings-section {
        padding: 1rem;
    }
    
    .profile-photo-container {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .settings-header {
        padding: 1rem;
    }
    
    .table-settings td,
    .table-settings th {
        padding: 1rem;
    }
}

/* Add container width */
.settings-container {
    width: 100%; /* Add this */
    max-width: 100%; /* Add this */
    padding: 0; /* Add this */
}

/* Update table styles for full width */
.settings-wrapper,
.settings-block,
.table-profile,
.table-settings {
    width: 100%;
    min-width: 100%;
}

.table-settings {
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
}

.table-settings td,
.table-settings th {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
}

.table-settings td:first-child {
    width: 250px; /* Fixed width for first column */
    min-width: 250px;
}

.table-settings td:last-child {
    width: auto; /* Takes remaining space */
}

/* Make form controls take full width */
.form-control,
select.form-control,
textarea.form-control {
    width: 100%;
    min-width: 100%;
    box-sizing: border-box;
}

/* Photo container adjustments */
.profile-photo-container {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 2rem;
}

/* Container adjustments */
.settings-container,
.notifications-wrapper {
    width: 100%;
    max-width: 100%;
    padding: 0;
    margin: 0;
}

/* Card adjustments */
.settings-section,
x-setting-card {
    width: 100%;
    max-width: 100%;
    margin: 0 0 2rem 0;
    padding: 2rem;
}

/* Table responsive wrapper */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Update settings actions alignment */
.settings-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    padding: 20px 40px;  /* Increased horizontal padding */
    border-top: 1px solid #E2E8F0;
    justify-content: flex-end; /* Add this */
}

/* Update table header actions alignment */
.table-add {
    display: flex;
    justify-content: flex-end; /* Add this */
    margin: 20px 40px;  /* Added margin top/bottom and increased sides */
}

.table-add button {
    padding: 10px 24px;  /* Increased padding */
    background: #4299E1;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
    min-width: 120px;  /* Added minimum width */
}

.table-add button:hover {
    background: #3182CE;
}

/* Update settings block padding */
.settings-block {
    padding: 20px; /* Add this */
    // ...existing styles...
}

/* Update card padding */
.settings-wrapper {
    padding: 20px; /* Add this */
    // ...existing styles...
}

x-setting-card {
    padding: 20px; /* Add this */
    // ...existing styles...
}

/* Add these new styles */
.action-bar {
    display: flex;
    justify-content: flex-end;
    padding: 0 1.5rem;
}

.btn-add {
    padding: 10px 24px;
    background: #4299E1;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-add:hover {
    background: #3182CE;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-icon {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-edit {
    background: #EBF8FF;
    color: #3182CE;
    border: 1px solid #BEE3F8;
}

.btn-delete {
    background: #FED7D7;
    color: #E53E3E;
    border: 1px solid #FEB2B2;
}

.btn-edit:hover {
    background: #BEE3F8;
}

.btn-delete:hover {
    background: #FEB2B2;
}

/* Update title styles - make all titles blue */
.settings-main-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #3182CE; /* Changed to blue */
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
    background: #3182CE; /* Changed to match title color */
    border-radius: 2px;
}

.settings-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #3182CE; /* Changed to blue */
    margin-bottom: 0.5rem;
}

/* Update section titles */
h2.settings-main-title, 
.settings-header h3,
.edit-form-header h3 {
    color: #3182CE;
}

/* Update action bar spacing */
.action-bar {
    display: flex;
    justify-content: flex-end;
    padding: 1.5rem 1.5rem 2rem; /* Increased bottom padding */
    margin-bottom: 1rem; /* Added margin bottom */
    border-bottom: 1px solid #E2E8F0; /* Added separator line */
}

/* Update Add button styles */
.btn-add {
    padding: 12px 24px; /* Increased padding */
    background: #4299E1;
    color: white;
    border: none;
    border-radius: 8px; /* Increased border radius */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 150px; /* Increased minimum width */
    box-shadow: 0 2px 4px rgba(66, 153, 225, 0.2);
}

.btn-add:hover {
    background: #3182CE;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(66, 153, 225, 0.3);
}

/* Update table spacing */
.table-profile {
    margin-top: 1rem; /* Added margin top */
}

.table-settings {
    margin-top: 0.5rem; /* Added margin top */
}

.profile-photo-container {
    display: flex;
    align-items: start;
    gap: 1.5rem;
}

.profile-photo-wrapper {
    width: 150px;
    height: 150px;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    position: relative;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.photo-actions .btn {
    width: 120px;
    text-align: center;
}

.hidden {
    display: none;
}

/* Enhanced Button Styles */
.btn-add {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #4F46E5, #3B82F6);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    text-decoration: none;
    min-width: 120px;
}

.btn-add:hover {
    background: linear-gradient(135deg, #3B82F6, #4F46E5);
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
}

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

.action-bar {
    display: flex;
    justify-content: flex-end;
    padding: 1rem;
    margin-bottom: 1rem;
}

/* Update photo container and wrapper styles */
.profile-photo-container {
    display: flex;
    align-items: start;
    gap: 1.5rem;
    max-width: 300px; /* Limit container width */
}

.profile-photo-wrapper {
    width: 200px;         /* Fixed width */
    height: 120px;        /* Fixed height with 16:9 aspect ratio */
    border-radius: 0.5rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    position: relative;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-photo {
    width: 100%;
    height: 100%;
    object-fit: contain;  /* Changed to contain to prevent stretching */
    object-position: center;
}

/* Rest of your existing styles... */

/* Update photo actions styles */
.photo-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    margin-top: 0.5rem;
    flex-direction: row; /* Changed from column to row */
}

.photo-actions .btn {
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    height: 28px;
    min-width: 70px;
}

/* Update container styles */
.profile-photo-container {
    width: auto;
    max-width: 200px;
}

.profile-photo-wrapper {
    width: 200px;
    height: 100px;
    margin-bottom: 0.5rem !important;
}

/* Photo container and frame alignment */
.profile-photo-container {
    width: auto;
    max-width: 165px; /* Match exact width of both buttons combined */
}

.profile-photo-wrapper {
    width: 165px; /* Match container width */
    height: 90px;
    margin-bottom: 0.5rem !important;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}

.photo-actions {
    display: flex;
    justify-content: space-between;
    width: 165px; /* Match wrapper width exactly */
    gap: 5px;
    margin-top: 0.5rem;
}

.photo-actions .btn {
    flex: 1;
    padding: 0.25rem 0;
    font-size: 0.75rem;
    height: 26px;
    min-width: 80px;
    border-radius: 0.375rem;
}
</style>
