<?php

namespace App\Authorization;

enum TeamPermissions: string
{
    case INVITE_MEMBER = 'invite-member';
    case REMOVE_MEMBER = 'remove-member';
    case UPDATE_ROLE = 'update-role';
}
