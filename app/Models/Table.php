<?php

namespace App\Models;

use App\Enums\TableLocation;
use App\Enums\TableStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guest_number',
        'status',
        'location_id' 
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    public function location()
    {
       return $this->belongsTo(Location::class,'location_id');
    }
    
    public function hasReservationOnDate($date)
    {
    return $this->reservations()->whereDate('res_date', $date)->exists();
   }
}
