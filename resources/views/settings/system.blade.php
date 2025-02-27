@extends('app')


@section('content')

@include('partials.navbar')

<div class="content">

@include('partials.sidebar')

    <div class="wrapper-system-content">

        <div class="breadcrumb">
            <span>General Workspace</span>
            <div class="link-breadcrumb">
                <ul>
                    <li><a href="/">Whello</a></li>
                    <li>System settings</li>
                </ul>
            </div>
        </div>

        <div class="setting-system-wrapper">
            <div class="system-menu-wrapper">
                <ul class="system-menu">
                    <li class="system-items">
                        <a href="#" class="system-link" data-target="#general-workspace">
                            <img src="{{ asset('images/briefcase.svg') }}" alt="" class="icon">
                            <span>General Workspace</span>
                        </a>
                    </li>
                    <li class="system-items">
                        <a href="#" class="system-link" data-target="#working-day">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Working Day</span>
                        </a>
                    </li>
                    <li class="system-items">
                        <a href="#" class="system-link" data-target="#project-utility">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Project Utility</span>
                        </a>
                    </li>
                    <li class="system-items">
                        <a href="#" class="system-link" data-target="#time-and-expenses">
                            <img src="{{ asset('images/timer-pause.svg') }}" alt="" class="icon">
                            <span>Time & Expenses</span>
                        </a>
                    </li>
                    <li class="system-divider"></li> <!-- Separator -->
                </ul>
            </div>
            <div class="system-info-wrapper">
                @include('partials.system.general-workspace')
                @include('partials.system.working-day')
                @include('partials.system.project-utility')
                @include('partials.system.time-and-expenses')
            </div>
        </div>
    </div>
</div>
@endsection
