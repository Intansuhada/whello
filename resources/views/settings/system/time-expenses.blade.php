@extends('settings.system')

@section('system-content')
<section class="content-detail" id="time-and-expenses">
    <div class="time-and-expenses">
        <div class="time-and-expenses-info">
            <div class="time-and-expenses-content1">
                <div class="card">
                    <div class="card-body">
                        <h2>Time Settings</h2>
                        <div class="form-system-setting">
                            <form action="{{ route('system.time-expenses.update') }}" method="POST">
                                @csrf
                                <p>Time & Expenses</p>
                                <!-- Add form fields for time settings -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <li class="profile-divider"></li> <!-- Separator -->

            <div class="time-and-expenses-content2">
                <div class="card">
                    <div class="card-body">
                        <h2>Expenses Settings</h2>
                        <div class="form-system-setting">
                            <form action="{{ route('system.time-expenses.update') }}" method="POST">
                                @csrf
                                <p>Time & Expenses</p>
                                <!-- Add form fields for expenses settings -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.time-and-expenses-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.profile-divider {
    border-top: 1px solid #e5e7eb;
    margin: 1rem 0;
    list-style: none;
}

.card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
</style>
@endpush
