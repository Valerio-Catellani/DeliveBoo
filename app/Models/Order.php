<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Dish;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('dish_name', 'dish_price', 'dish_quantity')->withTimestamps();
    }
}
