<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Dish;
use App\Models\Typology;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

    public function typologies()
    {
        return $this->belongsToMany(Typology::class);
    }
}
