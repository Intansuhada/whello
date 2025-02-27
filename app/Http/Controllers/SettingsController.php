<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Mengambil data pengguna dan menampilkan tampilan profil.
     *
     * @return View
     */
    public function profileView(): View
    {
        // Get user data
        $user = Auth::user();

        return view('settings.profile', [
            'title' => 'Profile Settings',
            'user' => $user
        ]);
    }
}
