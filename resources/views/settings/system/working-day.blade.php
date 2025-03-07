@extends('settings.system')

@section('system-content')
<section class="content-detail" id="working-day">
    <div class="working-day">
        <div class="working-day-info">
            <form action="{{ route('system.working-day.update') }}" method="POST">
                @csrf
                <div class="form-working-day">
                    <p><strong>Default Working Days & Hours </strong></p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>

                <div class="oclock-and-day">
                    <div class="toggle-day">
                        @foreach(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                            <div class="toggle">
                                <input class="input-toggle" type="checkbox" name="working_days[]" value="{{ $day }}" id="{{ $day }}">
                                <label for="{{ $day }}" class="button-toggle"></label>
                                <p>{{ ucfirst($day) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="set-waktu">
                        @for($i = 1; $i <= 4; $i++)
                        <div class="form-set-waktu">
                            <input type="text" name="time_slots[{{ $i }}][start1]" class="set-oclock" value="08.00 AM">
                            <span>to</span>
                            <input type="text" name="time_slots[{{ $i }}][end1]" class="set-oclock" value="12.00 AM">
                            <span>&</span>
                            <input type="text" name="time_slots[{{ $i }}][start2]" class="set-oclock" value="13.00 PM">
                            <span>to</span>
                            <input type="text" name="time_slots[{{ $i }}][end2]" class="set-oclock" value="05.00 PM">
                        </div>
                        @endfor
                    </div>
                </div>

                <li class="profile-divider"></li>

                <div class="form-working-day-setting">
                    <p><strong>Time Zone</strong></p>
                    <p>Lorem Ipsum is simply dummy text.</p>
                    <select name="timezone">
                        @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <option value="{{ strtolower($day) }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <li class="profile-divider"></li>
            </form>

            <!-- Leave Type Table -->
            @include('settings.system.partials.leave-type-table')

            <li class="profile-divider"></li>

            <!-- Company Holidays Table -->
            @include('settings.system.partials.company-holidays-table')
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.working-day-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.toggle-day {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.oclock-and-day {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.set-waktu {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-set-waktu {
    display: flex;
    align-items: center;
    gap: 10px;
}

.set-oclock {
    width: 100px;
    padding: 5px;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
}

.box-color {
    width: 20px;
    height: 20px;
    background: #4CAF50;
    border-radius: 4px;
}
</style>
@endpush
