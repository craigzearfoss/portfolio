<?php

namespace App\Enums;

enum EnvTypes: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';
}
