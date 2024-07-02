<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Order;

class Dish extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('dish_name', 'dish_price', 'dish_quantity')->withTimestamps();
    }

    public static function generateSlugForDish($dishName, $restaurantSlug)
    {
        $baseSlug  = Str::slug("{$restaurantSlug}_{$dishName}", '-');
        $slug = $baseSlug;
        $count = 1;
        while (Dish::where('slug', $slug)->exists()) {
            $slug ="{$baseSlug}-{$count}";
            $count++;
        }
        return $slug;
            // Concatenazione di nome e cognome

    }


}
