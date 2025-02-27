<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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
    public function index(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $token = DB::table('password_reset_tokens')->whereToken($request->route('token'))->first();

        if (!$token) {
            return redirect('/')->with('error', 'Invalid token. Please try again.');
        }

        return view('auth.reset-password', [
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
    public function update(Request $request): RedirectResponse {
        // Validate the request data
        $token = $request->route('token');

        $validator = Validator::make($request->all(), [
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
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