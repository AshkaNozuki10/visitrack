<?php

namespace App\Enums;

enum RoleEnum: string
{
    case STUDENT = 'student';
    case VISITOR = 'non_student';
    case FACULTY = 'faculty';
    case CONTRACTOR = 'contractor';
    case ADMIN = 'admin';
}
