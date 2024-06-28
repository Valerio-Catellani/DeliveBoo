<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTypology extends Model
{
    use HasFactory;
    protected $table = 'restaurant_typology';
    protected $guarded = [];
}
