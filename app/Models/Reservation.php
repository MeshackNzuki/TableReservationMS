<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'res_date',
        'guest_number',
        'checkout_date',
        'day_of_week',
        'recur_time',
        'recurring',
        'cancel',
        'ref'
    ];

    protected $dates = [
        'res_date',
        'checkout_date'
    ];

    protected $casts = [
        'res_date' => 'datetime',
        'checkout_date' => 'datetime'
    ];


    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}