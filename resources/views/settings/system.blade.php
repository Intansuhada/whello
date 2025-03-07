@extends('app')

@section('content')
@include('partials.navbar')

<div class="content">
    @include('partials.sidebar')
    
    <div class="wrapper-profile-content">
        <div class="breadcrumb">
            <span>General Workspace</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="{{ route('dashboard') }}">Whello</a></li>
                    <li>System Settings</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            <div class="profile-menu-wrapper">
                <ul class="profile-menu">
                    <li class="profile-items">
                        <a href="{{ route('system.general-workspace') }}" class="profile-link {{ Request::routeIs('system.general-workspace') ? 'active' : '' }}" data-target="#general-workspace">
                            <img src="{{ asset('images/briefcase.svg') }}" alt="" class="icon">
                            <span>General Workspace</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="{{ route('system.working-day') }}" class="profile-link {{ Request::routeIs('system.working-day') ? 'active' : '' }}" data-target="#working-day">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Working Day</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="{{ route('system.project-utility') }}" class="profile-link {{ Request::routeIs('system.project-utility') ? 'active' : '' }}" data-target="#project-utility">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Project Utility</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="{{ route('system.time-expenses') }}" class="profile-link {{ Request::routeIs('system.time-expenses') ? 'active' : '' }}" data-target="#time-and-expenses">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Time & Expenses</span>
                        </a>
                    </li>
                    <div class="profile-divider"></div>
                </ul>
            </div>

            <div class="profile-info-wrapper">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                
                @yield('system-content')
            </div>
        </div>
    </div>
</div>
@endsection
