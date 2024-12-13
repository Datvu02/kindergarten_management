<?php

namespace App\Enums;

enum RoleEnum: int
{
    case PRINCIPAL = 1;
    case HOMEROOM_TEACHER = 2;
    case TEACHER = 3;
    case PUPIL = 4;

    function getRandomKey() : int {
        return random_int(1,4);
    }
}
