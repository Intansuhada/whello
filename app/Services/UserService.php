<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserInvite;

class UserService
{
    public function deleteUser(User $user)
    {
        // Delete related invites first
        UserInvite::where('invite_email', $user->email)->delete();
        
        // Delete the user
        return $user->delete();
    }
}
