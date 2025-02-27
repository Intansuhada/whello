<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['guest'];
    }

    /**
     * Mengembalikan tampilan untuk halaman reset password.
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('forgot-password', [
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
    public function sendToEmailPasswordReset(Request $request): RedirectResponse 
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $user = User::where('email', $email)->first();
        if($user) {
            // Check if token already exists and regenerate if exists
            $token = DB::table('password_reset_tokens')->where('email', $email)->first(['email', 'token']);
            if ($token) {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
            }

            $token = Str::random(64);
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

        return back()->with('error', 'Email tidak terdaftar!');
    }

    /**
     * Mengembalikan tampilan untuk halaman reset password.
     * 
     * @return \Illuminate\View\View
     */

    public function resetPasswordView(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        $token = DB::table('password_reset_tokens')->whereToken($request->route('token'))->first();

        if (!$token) {
            return redirect('/')->with('error', 'Invalid token. Please try again.');
        }

        return view('reset-password', [
            'title' => 'Reset Password',
            'token' => $token->token,
        ]);
    }

    /**
     * Mereset password pengguna berdasarkan email, token, dan password baru yang diberikan.
     *
     * @param \Illuminate\Http\Request $request Permintaan HTTP yang berisi email, token, dan password baru.
     * @return \Illuminate\Http\RedirectResponse Mengarahkan pengguna berdasarkan hasil reset password.
     * 
     */
    public function resetPassword(Request $request): RedirectResponse {
        // Validate the request data
        $token = $request->route('token');

        $validator = Validator::make($request->all(), [
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Obtain email address from token
        $user = DB::table('password_reset_tokens')->where('token', $token)->first();
        $email = $user->email;

        // Update password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        
        return redirect(route('auth.signin-page'))->with('success', 'Your password has been reset.');
    }
}
