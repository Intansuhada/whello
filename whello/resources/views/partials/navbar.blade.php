<header>
    <nav class="navbar">
        <div class="navbar-left">
            <div class="sidebar-logo">
                <img src="{{ asset('images/whello-logo.svg') }}" alt="Whello Logo">
            </div>
            <div class="sidebar-divider-nav"></div>
        </div>
        <div class="navbar-center">
            <div class="search">
                <input type="text" placeholder="Search..." class="sidebar-search-input">
                <img src="{{ asset('images/search.svg') }}" alt="Search Icon" class="search-icon">
                <a href="#" class="filter-link">
                    <i class="fa fa-filter filter-icon"></i> Search Filter
                </a>
            </div>
        </div>
        <div class="navbar-right">
            <div class="sidebar-user-icon">
                <!-- <i class="fa fa-user-circle"></i> -->
                <div class="sidebar-profile-name">
                    <img src="{{ asset('images/account.svg') }}" alt="Avatar" class="sidebar-profile-img">
                    <span>{{ Auth::user()->name }}</span>
                    <img src="{{ asset('images/Arrow - Down 2.svg') }}" alt="Avatar" class="sidebar-profile-arrow">
                </div>
            </div>
        </div>
    </nav>
</header>
