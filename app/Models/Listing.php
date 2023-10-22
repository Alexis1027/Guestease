<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
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
        'rules',
        'monthly_discount',
        'bldg_permit'
    ];

}
