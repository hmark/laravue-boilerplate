<?php

namespace App\Enums;

enum ActivityType: string
{
    case Login = "Login";
    case Logout = "Logout";
    case Register = "Register";
}
