<?php

namespace App\Services\Web;

use App\Models\User;

readonly class UserService
{
    // get User by ID function
    public function getUserByID($id)
    {
        $user = User::find($id);

        return $user;
    }

    // get User function
    public function getUser($text)
    {
        $user = User::where('email', $text)
            ->orWhere('commercial_registration_number', $text)
            ->first();

        return $user;
    }
}
