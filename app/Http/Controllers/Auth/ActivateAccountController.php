<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ActivateAccountController extends Controller
{
    public function showActivationForm($token)
    {
        $user = User::where('activation_token', $token)->first();
        
        if (!$user) {
            Log::warning('Invalid activation attempt with token: ' . $token);
            return redirect()->route('auth.signin-page')
                           ->with('error', 'Link aktivasi tidak valid atau sudah kadaluarsa.');
        }

        if ($user->email_verified_at !== null) {
            return redirect()->route('auth.signin-page')
                           ->with('error', 'Akun ini sudah diaktifkan sebelumnya.');
        }

        return view('activate-account', [
            'token' => $token,
            'email' => $user->email
        ]);
    }

    public function activate(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('activation_token', $token)
                    ->whereNull('email_verified_at')
                    ->first();

        if (!$user) {
            Log::warning('Failed activation attempt with token: ' . $token);
            return back()->with('error', 'Link aktivasi tidak valid atau sudah kadaluarsa.');
        }

        try {
            $user->password = Hash::make($request->password);
            $user->activation_token = null;
            $user->email_verified_at = now();
            $user->save();

            Log::info('User activated successfully: ' . $user->email);

            return redirect()->route('auth.signin-page')
                ->with('success', 'Akun berhasil diaktifkan. Silakan login dengan email dan password Anda.');
        } catch (\Exception $e) {
            Log::error('Error during account activation: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat aktivasi akun. Silakan coba lagi.');
        }
    }
}
