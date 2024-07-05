<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Dish;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];




    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('dish_name', 'dish_price', 'dish_quantity')->withTimestamps();
    }


    public static function generateSlugForOrder($restaurantSlug)
    {
        $baseSlug  = Str::slug("{$restaurantSlug}-order-");
        //$slug = $baseSlug;
        $count = 1;
        $slug = "{$baseSlug}-{$count}";
        while (Order::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }
        return $slug;
        // Concatenazione di nome e cognome

    }
}
