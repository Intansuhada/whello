<div class="user-tab-content">
    <div class="tab-header">
        <h2>Recent Activities</h2>
    </div>
    <div class="tab-body">
        <div class="activity-timeline">
            @if(isset($activities) && count($activities) > 0)
                @foreach($activities as $activity)
                <div class="activity-item">
                    <div class="activity-info">
                        <span class="activity-type">{{ $activity->type }}</span>
                        <p class="activity-description">{{ $activity->description }}</p>
                        <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No recent activities</p>
                </div>
            @endif
        </div>
    </div>
</div>
