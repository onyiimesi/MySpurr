<?php

namespace App\Enum;

enum UserStatus: string
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const SUSPENDED = 'suspended';
    const BLOCKED = 'blocked';
}
