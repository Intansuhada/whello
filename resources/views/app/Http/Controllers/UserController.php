<?php

namespace App\Http\Controllers;

use App\Mail\InvitationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [ 'admin' ];
    }

    /**
     * Mengembalikan tampilan untuk halaman users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $users = User::with(['role', 'profile'])->get();
        $inactivatedAccounts = DB::table('inactivated_user_accounts')->get();

        return view('users', [
            'title' => 'Users',
            'users' => $users,
            'inactivatedAccounts' => $inactivatedAccounts
        ]);
    }

    /**
     * Mengambil data salah satu user.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse {
        $user = User::with(['role', 'profile.jobTitle.department'])->find($id);
        return response()->json(['status' => 200, 'message' => 'Success fetching data', 'user' => $user]);
    }

    /**
     * Menghapus data salah satu user.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse {
        User::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'User deleted successfully.']);
    }

    /**
     * Melakukan invite user baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createInvitation(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Check if user already exists
        $user = User::where('email', $email)->first();
        if ($user) {
            return back()->with('error', 'User already exists!');
        }

        $credential = DB::table('inactivated_user_accounts')->where('email', $email)->first();
        if ($credential) {
            return back()->with('error', 'Invitation already sent to ' . $email);
        }

        $token = Str::random(64);                       

        DB::table('inactivated_user_accounts')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($email)->send(new InvitationEmail(email: $email, token: $token));
        return back()->with('success', 'Invitation sent to ' . $request->input('email'));
    }
}
