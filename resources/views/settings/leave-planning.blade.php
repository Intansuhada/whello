@extends('app')

@section('content')
@include('partials.navbar')
<div class="content">
    @include('partials.sidebar')
    <div class="wrapper-profile-content">
        <div class="breadcrumb">
            <span>Leave Planning</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="{{ route('dashboard') }}">Whello</a></li>
                    <li>Leave Planning</li>
                </ul>
            </div>
        </div>

        <div class="setting-profile-wrapper">
            <div class="profile-menu-wrapper">
                <ul class="profile-menu">
                    <li class="profile-items">
                        <a href="{{ route('system.leave.calendar') }}" class="profile-link {{ Request::routeIs('system.leave.calendar') ? 'active' : '' }}">
                            <img src="{{ asset('images/calendar.svg') }}" alt="" class="icon">
                            <span>Leave Calendar</span>
                        </a>
                    </li>
                    <li class="profile-items">
                        <a href="{{ route('system.leave.history') }}" class="profile-link {{ Request::routeIs('system.leave.history') ? 'active' : '' }}">
                            <img src="{{ asset('images/list.svg') }}" alt="" class="icon">
                            <span>Leave History</span>
                        </a>
                    </li>
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
                
                @yield('leave-content')
            </div>
        </div>
    </div>
</div>
@endsection
