<?php

namespace App\Enums;

enum ActivityType: string
{
    case LoginCookie = "LoginCookie";
    case LogoutCookie = "LogoutCookie";
    case Register = "Register";
    case LoginToken = "LoginToken";
    case LogoutToken = "LogoutToken";
}
