<?php

namespace App\Enums;

enum TableStatus: string
{
    const Pending = 'pending';
    const Available = 'available'; 
    const Unavailable = 'unavailable';
}