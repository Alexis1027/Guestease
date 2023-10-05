<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_id',
        'listing_id',
        'bldg_permit'
    ];
}
