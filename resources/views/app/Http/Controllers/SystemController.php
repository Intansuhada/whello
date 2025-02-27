<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;

class SystemController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['admin'];
    }

    public function index(): View
    {
        return view('settings.system', [
            'title' => 'System Settings',
        ]);
    }
}
