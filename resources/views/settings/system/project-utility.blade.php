@extends('settings.system')

@section('system-content')
<section class="content-detail" id="project-utility">
    <div class="project-utility">
        <div class="project-utility-info">
            <div class="project-utility-content1">
                <div class="card">
                    <div class="card-body">
                        <h2>Project Utility Settings</h2>
                        <div class="form-system-setting">
                            <form action="{{ route('system.project-utility.update') }}" method="POST">
                                @csrf
                                <!-- Add your project utility form content here -->
                                <p>Project-Utility</p>
                                <!-- Add form fields for content1 -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <li class="profile-divider"></li> <!-- Separator -->

            <div class="project-utility-content2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-system-setting">
                            <form action="{{ route('system.project-utility.update') }}" method="POST">
                                @csrf
                                <!-- Add your project utility form content here -->
                                <p>Project-Utility</p>
                                <!-- Add form fields for content2 -->
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
.project-utility-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.profile-divider {
    border-top: 1px solid #e5e7eb;
    margin: 1rem 0;
    list-style: none;
}
</style>
@endpush
