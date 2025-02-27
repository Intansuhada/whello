<div class="sidebar-list">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <img src="{{ asset('images/overviews.svg') }}" alt="Overview Icon" class="icon">
                    <span>Overview</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/mywork.svg') }}" alt="My Works Icon" class="icon">
                    <span>My Works</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/notifications.svg') }}" alt="Notifications Icon" class="icon">
                    <span>Notifications</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/clients.svg') }}" alt="Clients Icon" class="icon">
                    <span>Clients</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/project.svg') }}" alt="Projects Icon" class="icon">
                    <span>Projects</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/tickets.svg') }}" alt="Tickets Icon" class="icon">
                    <span>Tickets</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/websites.svg') }}" alt="Websites Icon" class="icon">
                    <span>Websites</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/trackings.svg') }}" alt="Trackings Icon" class="icon">
                    <span>Trackings</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/workloads.svg') }}" alt="Workloads Icon" class="icon">
                    <span>Workloads</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/reports.svg') }}" alt="Reports Icon" class="icon">
                    <span>Reports</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/activities.svg') }}" alt="Activities Icon" class="icon">
                    <span>Activities</span>
                </a>
            </li>
            @if (Auth::user()->role_id == 1)
                <li class="sidebar-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <a href="/users" class="sidebar-link">
                        <img src="{{ asset('images/users.svg') }}" alt="Users Icon" class="icon">
                         <span>Users</span>
                    </a>
                </li>
            @endif
            <li class="sidebar-item setting">
                <a href="#" class="sidebar-link">
                    <img src="{{ asset('images/settings.svg') }}" alt="Settings Icon" class="icon">
                    <span>Settings</span>
                    <img src="{{ asset('images/arrow-down.svg') }}" alt="Avatar" class="sidebar-arrow">
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('settings.profile') }}" class="submenu-link">Profile</a></li>
                    @if (Auth::user()->role_id == 1)
                        <li><a href="{{ route('settings.system') }}" class="submenu-link">System</a></li>
                    @endif
                    <li><a href="#" class="submenu-link">Leave Planning</a></li>
                    <li><a href="#" class="submenu-link">Help</a></li>
                    <li><a href="{{ route('auth.logout') }}" class="submenu-link">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
