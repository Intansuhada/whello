<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\User;

class ActivateAccountController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['guest'];
    }

    /**
     * Membuat tampilan untuk membuat password baru berdasarkan permintaan yang diberikan.
     *
     * @param Request $request Objek request yang berisi token.
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        $token = $request->route('token');
        $credential = DB::table('inactivated_user_accounts')->where('token', $token)->first();

        if (!$credential) {
            return redirect('/')->with('error', 'Invalid token!');
        }

        return view('auth.activate-account', [
            'title' => 'Activate Your Account',
            'token' => $token,
        ]);
    }

    /**
     * Membuat akun pengguna baru.
     *
     * @param Request $request The HTTP request object.
     * @return RedirectResponse The redirect response.
     */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols(), 'confirmed'],
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $token = $request->route('token');
        $credential = DB::table('inactivated_user_accounts')->where('token', $token)->first();

        $user = User::create([
            'email' => $credential->email,
            'password' => $request->input('password'),
        ]);

        $user->profile()->create([
            'name' => explode('@', $credential->email)[0],
            'avatar' => null,
        ]);

        DB::table('inactivated_user_accounts')->where('token', $token)->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('auth.signin-page'))->with('success', 'Your account has been activated. Please sign in.');
    }
}
