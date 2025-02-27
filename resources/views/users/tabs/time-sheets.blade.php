<div class="user-tab-content">
    <div class="tab-header">
        <h2>Time Sheets</h2>
        <button class="log-time-btn">+ Log Time</button>
    </div>
    <div class="tab-body">
        <div class="time-sheet-list">
            @if(isset($timeSheets) && count($timeSheets) > 0)
                @foreach($timeSheets as $sheet)
                <div class="time-entry">
                    <div class="entry-info">
                        <h3>{{ $sheet->project_name }}</h3>
                        <p>{{ $sheet->task_name }}</p>
                        <div class="entry-meta">
                            <span class="hours">{{ $sheet->hours }} hours</span>
                            <span class="date">{{ $sheet->date }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No time entries recorded</p>
                </div>
            @endif
        </div>
    </div>
</div>
