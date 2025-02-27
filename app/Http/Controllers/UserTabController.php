<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserTabController extends Controller
{
    public function overview(User $user)
    {
        return view('users.tabs.overview', compact('user'));
    }

    public function client(User $user)
    {
        $clients = $user->clients ?? collect([]);
        return view('users.tabs.client', compact('user', 'clients'));
    }

    public function project(User $user)
    {
        $projects = $user->projects ?? collect([]);
        return view('users.tabs.project', compact('user', 'projects'));
    }

    public function task(User $user)
    {
        $tasks = $user->tasks ?? collect([]);
        return view('users.tabs.task', compact('user', 'tasks'));
    }

    public function leavePlanner(User $user)
    {
        $leaves = $user->leaves ?? collect([]);
        return view('users.tabs.leave-planner', compact('user', 'leaves'));
    }

    public function timeSheets(User $user)
    {
        $timeSheets = $user->timeSheets ?? collect([]);
        return view('users.tabs.time-sheets', compact('user', 'timeSheets'));
    }

    public function activities(User $user)
    {
        $activities = $user->activities ?? collect([]);
        return view('users.tabs.activities', compact('user', 'activities'));
    }

    public function access(User $user)
    {
        return view('users.tabs.access', compact('user'));
    }
}
