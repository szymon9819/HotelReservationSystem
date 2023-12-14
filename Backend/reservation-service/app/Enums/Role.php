<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case TOUR_GUIDE = 'tour guide';

}
