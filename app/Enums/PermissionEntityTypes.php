<?php

namespace App\Enums;

enum PermissionEntityTypes: string
{
    case DATABASE = 'database';
    case RESOURCE = 'resource';
}
