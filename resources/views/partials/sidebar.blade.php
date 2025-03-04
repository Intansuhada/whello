<div class="sidebar-list" id="sidebar" style="font-family: inherit;">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/overviews.svg') }}" alt="Overview Icon" class="icon">
                    <span>Overview</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('My Works') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/mywork.svg') }}" alt="My Works Icon" class="icon">
                    <span>My Works</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Notifications') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/notifications.svg') }}" alt="Notifications Icon" class="icon">
                    <span>Notifications</span>
                </a>
            </li>
                <li class="sidebar-item {{ request()->routeIs('Clients') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/clients.svg') }}" alt="Clients Icon" class="icon">
                    <span>Clients</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Projects') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/project.svg') }}" alt="Projects Icon" class="icon">
                    <span>Projects</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Tickets') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/tickets.svg') }}" alt="Tickets Icon" class="icon">
                    <span>Tickets</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Websites') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/websites.svg') }}" alt="Websites Icon" class="icon">
                    <span>Websites</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Trackings') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/trackings.svg') }}" alt="Trackings Icon" class="icon">
                    <span>Trackings</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Workloads') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/workloads.svg') }}" alt="Workloads Icon" class="icon">
                    <span>Workloads</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Reports') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/reports.svg') }}" alt="Reports Icon" class="icon">
                    <span>Reports</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('Activities') ? 'active' : '' }}">
                <a href="#" class="sidebar-link main-menu-link">
                    <img src="{{ asset('images/activities.svg') }}" alt="Activities Icon" class="icon">
                    <span>Activities</span>
                </a>
            </li>
            @if (Auth::user()->role_id == 1)
                <li class="sidebar-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <a href="/users" class="sidebar-link main-menu-link">
                        <img src="{{ asset('images/users.svg') }}" alt="Users Icon" class="icon">
                        <span>Users</span>
                    </a>
                </li>
            @endif
            <li class="sidebar-item setting">
                <a href="#" class="sidebar-link" id="settings-menu">
                    <img src="{{ asset('images/settings.svg') }}" alt="Settings Icon" class="icon">
                    <span>Settings</span>
                    <span class="sidebar-settings-arrow" id="settings-arrow">></span>
                </a>
                <ul class="submenu" id="settings-submenu" style="display: none;">
                    <li>
                        <a href="{{ route('settings.profile') }}" class="submenu-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                            Profile
                        </a>
                    </li>
                    @if (Auth::user()->role_id == 1)
                        <li>
                            <a href="{{ route('settings.system') }}" class="submenu-link {{ request()->routeIs('settings.system') ? 'active' : '' }}">
                                System
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="#" class="submenu-link {{ request()->is('leave-planning') ? 'active' : '' }}">
                            Leave Planning
                        </a>
                    </li>
                    <li>
                        <a href="#" class="submenu-link {{ request()->is('help') ? 'active' : '' }}">
                            Help
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auth.logout') }}" class="submenu-link">
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const settingsMenu = document.getElementById("settings-menu");
    const settingsSubmenu = document.getElementById("settings-submenu");
    const settingsArrow = document.getElementById("settings-arrow");
    const mainMenuLinks = document.querySelectorAll(".main-menu-link");
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebar = document.querySelector(".sidebar");
    const navbar = document.querySelector(".navbar");
    const burgerMenu = document.getElementById("burger-menu");

        // Ambil status terakhir dari sessionStorage
        let isSubmenuOpen = sessionStorage.getItem("submenuOpen") === "true";

        // Pastikan submenu hanya terbuka jika sebelumnya terbuka
        if (isSubmenuOpen) {
            settingsSubmenu.style.display = "block";
            settingsArrow.style.transform = "rotate(90deg)";
        } else {
            settingsSubmenu.style.display = "none";
            settingsArrow.style.transform = "rotate(0deg)";
        }

        // Fungsi untuk menutup submenu Settings
        function closeSettingsSubmenu() {
            settingsSubmenu.style.display = "none";
            settingsArrow.style.transform = "rotate(0deg)";
            sessionStorage.setItem("submenuOpen", "false");
        }

        // Event listener untuk menu utama selain "Settings"
        mainMenuLinks.forEach(link => {
            link.addEventListener("click", function() {
                if (!link.classList.contains("settings-toggle")) {
                    closeSettingsSubmenu(); // Tutup submenu jika menu lain diklik
                }
            });
        });

        // Event listener untuk klik pada menu "Settings"
        settingsMenu.addEventListener("click", function(event) {
            event.stopPropagation(); // Mencegah event bubbling
            let isCurrentlyOpen = settingsSubmenu.style.display === "block";

            if (isCurrentlyOpen) {
                closeSettingsSubmenu();
            } else {
                settingsSubmenu.style.display = "block";
                settingsArrow.style.transform = "rotate(90deg)";
                sessionStorage.setItem("submenuOpen", "true");
            }
        });

        // Klik di luar menu akan menutup submenu
        document.addEventListener("click", function(event) {
            if (!settingsMenu.contains(event.target) && !settingsSubmenu.contains(event.target)) {
                closeSettingsSubmenu();
            }
        });

        // Toggle sidebar and navbar visibility with smooth animation
        if (sidebarToggle && sidebar && navbar) {
        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");
            navbar.classList.toggle("collapsed");
        });
    } else {
        console.error("Sidebar atau navbar tidak ditemukan di dalam DOM.");
    }
    document.getElementById("burger-menu").addEventListener("click", function() {
    let sidebar = document.querySelector(".sidebar");
    let submenu = document.querySelector(".submenu");

    sidebar.classList.toggle("collapsed");

    // Sembunyikan atau tampilkan submenu berdasarkan kelas sidebar
    if (sidebar.classList.contains("collapsed")) {
        submenu.style.display = "none";
    } else {
        submenu.style.display = "block";
    }
});

   // **Perbaikan utama: Toggle sidebar hanya jika burger menu diklik**
   burgerMenu.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");

        // Sembunyikan semua submenu jika sidebar ditutup
        if (sidebar.classList.contains("collapsed")) {
            document.querySelectorAll(".submenu").forEach(submenu => {
                submenu.style.display = "none";
            });
        }
    });

    // **Perbaikan utama: Mencegah sidebar terbuka sendiri saat menu sidebar diklik**
    document.querySelectorAll(".menu-item").forEach(item => {
        item.addEventListener("click", function (event) {
            if (sidebar.classList.contains("collapsed")) {
                event.stopPropagation(); // Mencegah klik membuka sidebar
                event.preventDefault(); // Mencegah perilaku default
            }
        });
          // Toggle menu utama dan submenu yang diklik
          item.classList.toggle("active");
            if (submenu) {
                submenu.classList.toggle("active");
                if (arrow) {
                    arrow.style.transform = submenu.classList.contains("active") ? "rotate(90deg)" : "rotate(0deg)";
                }
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");

    sidebar.addEventListener("mouseover", function () {
        sidebar.classList.add("expanded");
    });

    sidebar.addEventListener("mouseleave", function () {
        sidebar.classList.remove("expanded");
    });
});
let currentUrl = window.location.href;
    let submenuLinks = document.querySelectorAll(".submenu-link");

    submenuLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add("active"); // Tambahkan class active ke submenu yang aktif
            link.closest(".submenu").classList.add("active"); // Pastikan submenu tetap terbuka
        }
    });

    });


</script>