@extends('app')
@section('content')
@include('partials.navbar')
<div class="content">
    @include('partials.sidebar')
    <div class="wrapper-profile-content">
        <div class="breadcrumb">
            <span>Basic Profile</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="{{ route('dashboard') }}">Whello</a></li>
                    <li>My Profile</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            <div class="profile-menu-wrapper">
                <ul class="profile-menu">
                    <li class="profile-items">
                        <a href="{{ route('profile.basic') }}" class="profile-link {{ Request::routeIs('profile.basic') ? 'active' : '' }}">
                            <img src="{{ asset('images/profile-circle.svg') }}" alt="" class="icon">
                            <span>Basic Profile</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="{{ route('profile.account-security') }}" class="profile-link {{ Request::routeIs('profile.account-security') ? 'active' : '' }}">
                            <img src="{{ asset('images/shield-slash.svg') }}" alt="" class="icon">
                            <span>Account & Security</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="{{ route('profile.notifications') }}" class="profile-link {{ Request::routeIs('profile.notifications') ? 'active' : '' }}">
                            <img src="{{ asset('images/notification-bing.svg') }}" alt="" class="icon">
                            <span>Notifications</span>
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
                @yield('profile-content')
            </div>
        </div>
    </div>
</div>
@endsection