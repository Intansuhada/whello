<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Mail\PasswordReset;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Mengembalikan tampilan untuk halaman reset password.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('auth.forgot-password', [
            'title' => 'Lupa Password',
        ]);
    }

    /**
     * Mengirimkan email untuk mereset kata sandi.
     *
     *
     * @param \Illuminate\Http\Request $request Objek request.
     * @return \Illuminate\Http\RedirectResponse Objek RedirectResponse ke halaman signin.
     */
    public function sendEmail(Request $request): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if($user) {
            $token = DB::table('password_reset_tokens')->where('email', $email)->first(['email', 'token']);
            
            if ($token) {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
            }

            $token = Str::random(32);
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now(),
                'expires_at' => now()->addMinutes(15),
            ]);

            // Mail to user using PasswordReset mail
            Mail::to($email)->send(new PasswordReset(user: $user, token: $token));
            return back()->with('success', 'We have sent you an email to reset your password. Check your email.');
        }

        return back()->with('error', 'User not found!');
    }
}
