<?php

namespace App\Authorization;

enum SpacePermissions: string
{
    case CREATE = 'create_spaces';
    case UPDATE = 'update_spaces';
    case DELETE = 'delete_spaces';
    case VIEW = 'view_spaces';
    case LIST = 'list_spaces';
}
