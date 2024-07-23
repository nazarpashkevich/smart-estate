<?php

namespace App\Domains\Estate\Enums;

enum EstateApplicationStatus: string
{
    case New = 'new';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
