<div class="user-tab-content">
    <div class="tab-header">
        <h2>Project Management</h2>
        <button class="add-project-btn">+ Add New Project</button>
    </div>
    <div class="tab-body">
        <div class="project-list">
            @if(isset($projects) && count($projects) > 0)
                @foreach($projects as $project)
                <div class="project-item">
                    <div class="project-info">
                        <h3>{{ $project->name }}</h3>
                        <p>{{ $project->description }}</p>
                        <div class="project-meta">
                            <span class="deadline">Deadline: {{ $project->deadline }}</span>
                            <span class="status {{ $project->status }}">{{ ucfirst($project->status) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No projects assigned</p>
                </div>
            @endif
        </div>
    </div>
</div>
