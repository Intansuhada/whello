<section class="content-detail active" id="my-profile">
    <div class="profile-info">
        <div class="photo-profile">
            <p><strong>Photo Profile</strong></p>
            <p>Please upload your photo with a maximum size of 2048 KB!</p>
            <br>
            <div class="profile-photo-placeholder">
                <img src="{{ $user->profile && $user->profile->avatar ? url('images/avatars/' . $user->profile->avatar) : asset('images/change-photo.svg') }}" 
                     alt="Change Photo" 
                     class="profile-photo">
                <div class="overlay" id="btn-change-photo">Change Photo</div>
                <button class="close-photo" id="btn-delete-photo">&times;</button>
            </div>
            <form id="photoForm" action="{{ route('settings.profile.change-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photo" id="photoInput" style="display: none;">
            </form>
            <form action="{{ route('settings.profile.delete-photo') }}" method="post" id="form-delete-photo">
                @method('DELETE')
                @csrf
            </form>
        </div>

        <form action="{{ route('settings.profile.update') }}" method="post" id="form-update-profile">
            @method('PUT')
            @csrf
            
            <div class="form-profile">
                <p><strong>Nickname</strong></p>
                <p>Nickname is used for identifying users in this platform.</p>
                <input type="text" name="nickname" value="{{ $user->profile ? $user->profile->nickname : '' }}">
            </div>
    
            <div class="form-profile">
                <p><strong>Full Name</strong></p>
                <p>Full Name is used for identifying users in this platform.</p>
                <input type="text" name="name" value="{{ $user->profile ? $user->profile->name : '' }}">
            </div>
    
            <div class="form-profile">
                <p><strong>About Me</strong></p>
                <p>Tell us something about yourself.</p>
                <textarea name="about" rows="5" style="line-height: 1.8">{{ $user->profile ? $user->profile->about : '' }}</textarea>
            </div>
    
            <div class="form-profile">
                <p><strong>Department</strong></p>
                <p>Department is a department that is associated with your job title.</p>
                <input type="text" name="department" value="{{ $user->profile && $user->profile->jobTitle ? $user->profile->jobTitle->department->name : 'No Department' }}" disabled>
            </div>

            <div class="form-profile">
                <p><strong>Job Title</strong></p>
                <p>Job title is a title that describes your job.</p>
                <select name="job_title" {{ $user->role && $user->role->id != 1 ? 'disabled' : '' }}>
                    @foreach ($jobTitles as $jobTitle)
                        <option value="{{ $jobTitle->id }}" {{ $user->profile && $user->profile->job_title_id == $jobTitle->id ? 'selected' : '' }}>{{ $jobTitle->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="form-profile">
            <p><strong>Default Working Days & Hours</strong></p>
            <p>
                This is the default working days and hours that will be used for all tasks, projects, and holidays.
                You can change this setting for each task, project, or holiday as needed. 
                If you don't set a different working days and hours for a task, project, or holiday, the default setting will be used.
            </p>
        </div>

        <div class="oclock-and-day">
            <div class="toggle-day">
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="sunday">
                    <label for="sunday" class="button-toggle"></label>
                    <p>Sunday</p>
                </div>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="monday">
                    <label for="monday" class="button-toggle"></label>
                    <p>Monday</p>
                </div>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="tuesday">
                    <label for="tuesday" class="button-toggle"></label>
                    <p>Tuesday</p>
                </div>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="wednesday">
                    <label for="wednesday" class="button-toggle"></label>
                    <p>Wednesday</p>
                </div>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="thursday">
                    <label for="thursday" class="button-toggle"></label>
                    <p>Thursday</p>
                </div>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="friday">
                    <label for="friday" class="button-toggle"></label>
                    <p>Friday</p>
                </div>
                <div class="toggle">
                    <input class="input-toggle" type="checkbox" id="saturday">
                    <label for="saturday" class="button-toggle"></label>
                    <p>Saturday</p>
                </div>
            </div>
            <div class="set-waktu">
                <div class="form-set-waktu">
                    <input type="text" class="set-oclock" value="08.00 AM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="12.00 AM">
                    <span>&</span>
                    <input type="text" class="set-oclock" value="13.00 PM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="05.00 PM">
                </div>
                <div class="form-set-waktu">
                    <input type="text" class="set-oclock" value="08.00 AM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="12.00 AM">
                    <span>&</span>
                    <input type="text" class="set-oclock" value="13.00 PM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="05.00 PM">
                </div>
                <div class="form-set-waktu">
                    <input type="text" class="set-oclock" value="08.00 AM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="12.00 AM">
                    <span>&</span>
                    <input type="text" class="set-oclock" value="13.00 PM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="05.00 PM">
                </div>
                <div class="form-set-waktu">
                    <input type="text" class="set-oclock" value="08.00 AM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="12.00 AM">
                    <span>&</span>
                    <input type="text" class="set-oclock" value="13.00 PM">
                    <span>to</span>
                    <input type="text" class="set-oclock" value="05.00 PM">
                </div>
            </div>
        </div>

        <div class="form-profile">
            <button type="submit" class="continue-button" style="max-width: 10%;" id="btn-update-profile">Submit</button>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    async function uploadPhoto(file) {
        const formData = new FormData();
        formData.append('photo', file);
        
        try {
            const response = await fetch('{{ route("settings.profile.change-photo") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            
            const data = await response.json();
            if (data.success) {
                // Update avatar display
                document.querySelector('.avatar-image').src = data.path;
            } else {
                alert('Failed to update photo');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error updating photo');
        }
    }
});
</script>
@endpush