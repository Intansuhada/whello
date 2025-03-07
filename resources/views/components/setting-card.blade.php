@props(['title' => null, 'hasHeader' => true])

<div class="card setting-card mb-4">
    @if($hasHeader && $title)
    <div class="card-header">
        <div class="settings-header">
            <h2 class="settings-title mb-0">{{ $title }}</h2>
        </div>
    </div>
    @endif
    
    <div class="card-body p-0">
        {{ $slot }}
    </div>
</div>

<style>
.setting-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background-color: white;
    border-bottom: 1px solid #e5e7eb;
    padding: 1.25rem 1.5rem;
}

.settings-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a202c;
    margin: 0;
}

.card-body {
    background-color: white;
}
</style>
