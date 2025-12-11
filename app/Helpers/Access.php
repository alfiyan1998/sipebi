<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Access
{
    public static function isUser()
    {
        return Auth::user()->role === Role::USER;
    }

    public static function isAdmin()
    {
        return Auth::user()->role === Role::ADMIN;
    }

    public static function isSuperadmin()
    {
        return Auth::user()->role === Role::SUPERADMIN;
    }

    public static function isAdminOrSuper()
    {
        return in_array(Auth::user()->role, [
            Role::ADMIN,
            Role::SUPERADMIN
        ]);
    }
}
