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
        'rooms'
    ];

    public function scopeFilter($query, array $filters) {

        if($filters['search'] ?? false) {
            $query->where('name', 'LIKE', '%'. request('search') .'%')
            ->orWhere('description', 'LIKE', '%'. request('search') .'%')
            ->orWhere('location', 'LIKE', '%'. request('search') .'%')
            ->orWhere('price', 'LIKE', '%'. request('search') .'%');
        }

    }
}
