<?php

namespace App\Domains\Estate\Enums;

enum EstateItemType: string
{
    case Apartment = 'apartment';
    case House = 'house';
    case Room = 'room';
}
