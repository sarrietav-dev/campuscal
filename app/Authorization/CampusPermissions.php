<?php

namespace App\Authorization;

enum CampusPermissions: string
{
    case CREATE = 'create_campus';
    case UPDATE = 'update_campus';
    case DELETE = 'delete_campus';
    case VIEW = 'view_campus';
    case LIST = 'list_campus';
}
