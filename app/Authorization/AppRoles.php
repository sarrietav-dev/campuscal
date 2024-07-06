<?php

namespace App\Authorization;

enum AppRoles: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case REQUESTER = 'requester';
    case DEVELOPER = 'developer';

    public function labels(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::REQUESTER => 'Solicitante',
            self::DEVELOPER => 'Desarrollador',
        };
    }
}
