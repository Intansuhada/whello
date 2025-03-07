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
                        <button class="btn-add">
                            Add Job Title
                        </button>
                    </div>
                    <table class="table table-settings mb-0">
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
                                            <button class="btn-icon btn-edit" data-id="{{ $job->id }}">Edit</button>
                                            <button class="btn-icon btn-delete" data-id="{{ $job->id }}">Delete</button>
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
