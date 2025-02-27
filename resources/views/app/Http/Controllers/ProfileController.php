<?php

namespace App\Http\Controllers;

use App\Mail\EmailAddressChanged;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['emailChanged'])
        ];
    }

    /**
     * Mengambil data pengguna dan menampilkan tampilan profil.
     *
     * @return View
     */
    public function index(): View
    {
        // Get user data
        $user = Auth::user();
        $jobTitles = JobTitle::all();

        return view('settings.profile', [
            'title' => 'Profile',
            'user' => $user,
            'jobTitles' => $jobTitles
        ]);
    }

    /**
     * Mengupdate data profil pengguna.
     *
     * @return void
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::user()->id);
        
        $user->profile->nickname = $request->input('nickname');
        $user->profile->name = $request->input('name');
        $user->profile->about = $request->input('about');

        $user->profile->save();

        return redirect()->back()->with('success', 'Your profile has been updated.');
    }

    public function changePhoto(Request $request)
    {
        $request->validate([
            '_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->profile->avatar && file_exists(public_path('images/avatars/' . $user->profile->avatar))) {
            unlink(public_path('images/avatars/' . $user->profile->avatar));
        }

        $photo = $request->file('_photo');
        $filename = time() . '.' . $photo->getClientOriginalExtension();

        $user->profile->avatar = $filename;
        if ($user->profile->save()) {
            $photo->move(public_path('images/avatars'), $filename);
        }

        return redirect()->back()->with('success', 'Your photo has been updated.');
    }
    
    public function verifyNewEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $emailAlreadyExists = User::where('email', $request->input('email'))->first();

        if ($emailAlreadyExists) {
            return redirect()->back()->with('error', 'Email already exists.');
        }

        $token = Str::random(32);
        DB::table('email_verifications')->insert([
            'email' => $request->email,
            'token' => $token,
            'user_id' => Auth::user()->id,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($request->email)->send(new EmailAddressChanged($request->email, $token));

        return redirect()->back()->with('success', 'Please check your email to verify your email address.');
    }

    public function emailChanged(Request $request)
    {
        $emailVerification = DB::table('email_verifications')->where('token', $request->route('token'))->first();

        if (!$emailVerification) { return $this->invalidateSession($request, 'Invalid token.'); }

        $user = User::find($emailVerification->user_id);

        $user->email = $emailVerification->email;
        $user->save();

        DB::table('email_verifications')->where('token', $request->route('token'))->delete();

        return $this->invalidateSession($request, 'Your email address has been changed.', true);
    }

    public function changeUsername(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->username = $request->input('username');
        $user->save();

        return redirect()->back()->with('success', 'Your username has been updated.');
    }

    
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->password = $request->input('password');
        $user->save();

        return $this->invalidateSession($request, 'Your password has been changed. Please sign in again.', true);
    }

    public function deletePhoto(Request $request)
    {
        $user = Auth::user();

        if ($user->profile->avatar && file_exists(public_path('images/avatars/' . $user->profile->avatar))) {
            unlink(public_path('images/avatars/' . $user->profile->avatar));
        }

        $user->profile->avatar = null;
        $user->profile->save();

        return redirect()->back()->with('success', 'Your photo has been deleted.');
    }

    private function invalidateSession($request, $message, $success = false): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        $status = $success ? 'success' : 'error';
        return redirect(route('auth.signin-page'))->with($status, $message);
    }
}   
