<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
        ];
    }

    /**
     * Returns the view for the signin page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function signinView(): View {
        // Clear any login session
        
        return view('auth.signin', [
            'title' => 'Sign In',
        ]);
    }

    /**
     * Mengembalikan tampilan untuk halaman pendaftaran (signup).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function signupView(): View {
        return view('auth.signup', [
            'title' => 'Sign Up',
        ]);
    }

    /**
     * Fungsi ini digunakan untuk melakukan registrasi pengguna.
     * Fungsi ini menerima objek request yang berisi data pengguna,
     * dan mengembalikan objek RedirectResponse yang akan mengarahkan pengguna
     * ke halaman dashboard jika registrasi berhasil.
     *
     * @param \Illuminate\Http\Request $request The request object containing user data.
     * @return \Illuminate\Http\RedirectResponse The RedirectResponse object that will redirect the user to the dashboard page if registration is successful.
     */
    public function signup(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = $request->input('email');
        $name = $request->input('name');
        $password = $request->input('password');

        if (User::where('email', $email)->exists()) {
            return back()->with('error', 'Email already registered');
        }

        $user = new User();
        $user->name = $name;
        $user->role_id = 2;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return redirect('/signin')->with('success', 'Akun anda telah terdaftar! Silahkan login.');
    }

    /**
     * Melakukan signin pengguna.
     * 
     * Fungsi ini digunakan untuk melakukan signin pengguna dengan menerima permintaan (request) yang berisi data pengguna.
     * Jika signin berhasil, maka akan diarahkan ke halaman dashboard.
     * 
     * @param \Illuminate\Http\Request $request Objek request yang berisi data pengguna.
     * @return \Illuminate\Http\RedirectResponse Objek RedirectResponse yang akan mengarahkan pengguna ke halaman dashboard jika login berhasil.
     */
    public function signin(Request $request) 
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Incorrect email or password! Please try again.');
    }

    
    /**
     * Logout pengguna.
     * 
     * @param \Illuminate\Http\Request $request Objek request.
     * @return \Illuminate\Http\RedirectResponse Objek RedirectResponse yang akan mengarahkan pengguna ke halaman login.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}