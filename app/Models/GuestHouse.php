<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestHouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_id',
        'title', 
        'description', 
        'location', 
        'price', 
        'images',
        'latitude',
        'longitude',
        'guests',
        'amenities',
        'beds',
        'bathrooms',
        'rooms',
        'status',
        'type',
    ];

}
