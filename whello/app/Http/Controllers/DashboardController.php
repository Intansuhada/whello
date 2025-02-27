<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    /**
     * Mengembalikan tampilan untuk halaman dashboard.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('overview', [
            'title' => 'Overview',
        ]);
    }
}
