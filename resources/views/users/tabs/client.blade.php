<div class="user-tab-content">
    <div class="tab-header">
        <h2>Client Management</h2>
        <button class="add-client-btn">+ Add New Client</button>
    </div>
    <div class="tab-body">
        <div class="client-list">
            @if(isset($clients) && count($clients) > 0)
                @foreach($clients as $client)
                <div class="client-item">
                    <div class="client-info">
                        <h3>{{ $client->name }}</h3>
                        <p>{{ $client->description }}</p>
                        <span class="client-status {{ $client->status }}">{{ ucfirst($client->status) }}</span>
                    </div>
                    <div class="client-actions">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No clients assigned yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="tab-detail active">
    <div class="tab-header">
        <h2>Client</h2>
    </div>
    <div class="tab-body">
        <p>Client content here</p>
    </div>
</div>
