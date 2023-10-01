<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_process',
        'user_id',
        'room_id',
        'status',
        'checkin',
        'checkout',
        'total',
        'guests',
        'days'
    ];
}
