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
                <div class="sidebar-profile-name">
                    <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar ? Storage::url(auth()->user()->profile->avatar) : asset('images/change-photo.svg') }}" 
                         alt="Avatar" 
                         class="sidebar-profile-img">
                    <span>{{ Auth::user()->profile ? Auth::user()->profile->name : Auth::user()->email }}</span>
                    <img src="{{ asset('images/arrow-down.svg') }}" alt="" class="sidebar-profile-arrow">
                </div>
            </div>
        </div>
    </nav>
</header>