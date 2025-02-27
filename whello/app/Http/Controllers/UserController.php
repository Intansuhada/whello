<?php

namespace App\Http\Controllers;

use App\Mail\InvitationEmail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar pengguna.
     */
    public function index()
    {
        $users = User::all();
        $pendingUsers = DB::table('inactivated_user_accounts')->get();

        return view('users', compact('users', 'pendingUsers'));
    }

    /**
     * Mengundang pengguna baru melalui email.
     */
    public function invite(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $email = $request->email;
        
        // Periksa apakah email sudah diundang sebelumnya
        $existingInvitation = DB::table('inactivated_user_accounts')->where('email', $email)->first();
        if ($existingInvitation) {
            return back()->with('error', 'Undangan sudah dikirim ke ' . $email);
        }

        $token = Str::random(64);

        DB::table('inactivated_user_accounts')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($email)->send(new InvitationEmail($email, $token));

        return back()->with('success', 'Undangan telah dikirim ke ' . $email);
    }

    /**
     * Menampilkan halaman aktivasi akun.
     */
    public function activateAccountView($token)
    {
        $credential = DB::table('inactivated_user_accounts')->where('token', $token)->first();
        if (!$credential) {
            return redirect()->route('auth.signin-page')->with('error', 'Token tidak valid atau telah kedaluwarsa.');
        }

        return view('activate-account', compact('token'));
    }

    /**
     * Mengaktifkan akun pengguna setelah memasukkan password.
     */
    public function activateAccount(Request $request, $token): RedirectResponse
    {
        $request->validate([
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols(), 'confirmed'],
        ]);

        $credential = DB::table('inactivated_user_accounts')->where('token', $token)->first();
        if (!$credential) {
            return back()->with('error', 'Token tidak valid atau telah kedaluwarsa.');
        }

        $user = User::create([
            'email' => $credential->email,
            'password' => Hash::make($request->password),
        ]);

        DB::table('inactivated_user_accounts')->where('token', $token)->delete();

        return redirect()->route('auth.signin-page')->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }
}
