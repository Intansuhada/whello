<div class="user-tab-content">
    <div class="tab-header">
        <h2>Task Management</h2>
        <button class="add-task-btn">+ Add New Task</button>
    </div>
    <div class="tab-body">
        <div class="task-list">
            @if(isset($tasks) && count($tasks) > 0)
                @foreach($tasks as $task)
                <div class="task-item">
                    <div class="task-info">
                        <h3>{{ $task->title }}</h3>
                        <p>{{ $task->description }}</p>
                        <div class="task-meta">
                            <span class="priority {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                            <span class="due-date">Due: {{ $task->due_date }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No tasks assigned</p>
                </div>
            @endif
        </div>
    </div>
</div>
