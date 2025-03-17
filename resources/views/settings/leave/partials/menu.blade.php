<div class="profile-menu-wrapper">
    <ul class="profile-menu">
        <li class="profile-items">
            <a href="{{ route('system.leave.calendar') }}" class="profile-link {{ request()->routeIs('system.leave.calendar') ? 'active' : '' }}">
                <img src="{{ asset('images/calendar.svg') }}" alt="" class="icon">
                <span>Leave Calendar</span>
            </a>
        </li>
        <li class="profile-items">
            <a href="{{ route('system.leave.history') }}" class="profile-link {{ request()->routeIs('system.leave.history') ? 'active' : '' }}">
                <img src="{{ asset('images/list.svg') }}" alt="" class="icon">
                <span>Leave History</span>
            </a>
        </li>
    </ul>
</div>
