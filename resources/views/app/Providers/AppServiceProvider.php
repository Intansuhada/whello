<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function($view) {
            // $sidebarItems = [
            //     [
            //         'href' => route('dashboard'),
            //         'icon' => 'overviews',
            //         'title' => 'Overview',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'mywork',
            //         'title' => 'My Works',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'notifications',
            //         'title' => 'Notifications',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'clients',
            //         'title' => 'Clients',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'project',
            //         'title' => 'Projects',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'tickets',
            //         'title' => 'Tickets',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'websites',
            //         'title' => 'Websites',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'trackings',
            //         'title' => 'Trackings',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'workloads',
            //         'title' => 'Workloads',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'reports',
            //         'title' => 'Reports',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'activities',
            //         'title' => 'Activities',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '/users',
            //         'icon' => 'users',
            //         'title' => 'Users',
            //         'submenu' => [],
            //     ],
            //     [
            //         'href' => '#',
            //         'icon' => 'settings',
            //         'title' => 'Settings',
            //         'submenu' => [
            //             [
            //                 'href' => route('profile.index'),
            //                 'title' => 'Profile',
            //             ],
            //             [
            //                 'href' => route('system.index'),
            //                 'title' => 'System',
            //             ],
            //             [
            //                 'href' => '#',
            //                 'title' => 'Leave Planning',
            //             ],
            //             [
            //                 'href' => '#',
            //                 'title' => 'Help',
            //             ],
            //             [
            //                 'href' => route('auth.logout'),
            //                 'title' => 'Logout',
            //             ]
            //         ],
            //     ],
            // ];

            // $view->with('sidebarItems', $sidebarItems);
        });
    }
}
