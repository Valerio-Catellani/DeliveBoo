<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class Typology extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }
}
