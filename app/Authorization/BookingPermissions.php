<?php

namespace App\Authorization;

enum BookingPermissions: string
{
    case CREATE = 'create_booking';
    case UPDATE = 'update_booking';
    case DELETE = 'delete_booking';
    case VIEW = 'view_bookings';
    case LIST = 'list_bookings';
    case APPROVE = 'approve_booking';
    case REJECT = 'reject_booking';
}
