<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Typology;
use App\Models\User;

use App\Functions\Helpers;
use Carbon\Carbon;


class DishController extends Controller
{
    public function findDishes(Request $request)
    {

        // http://127.0.0.1:8000/api/get-dishes?restaurant-slug=ristorante-onisto
        if ($request->query('restaurant-slug')) {

            $restaurant = Restaurant::where('slug', $request->query('restaurant-slug'))->first(); //recupero il ristorante in base al suo slug
            $dishesQuery = Dish::with(['restaurant', 'orders']); //assegno ad una variabile il comando di prendere anche i valori di user typologies e dishes, 
            //ATTENZIONE: questo non recupera i piatti (si noti l'assenza di all(), get(), o pgainate()) semplicmente dice che datai dovranno avere i pitatti dopo le query al db
            if ($request->query('visible') == 'all') {  //se il parametro visible è impostato a all , vogliamo tutti i piatti di un ristorante, anche quelli non visibili
                $dishesQuery = $dishesQuery
                    ->where('restaurant_id', $restaurant->id);
            } else {
                $dishesQuery = $dishesQuery
                    ->where('visible', true)
                    ->where('restaurant_id', $restaurant->id);
            }
            //inserisci la paginazione qui
            $dishes = $dishesQuery->get();
        }

        // http://127.0.0.1:8000/api/get-dishes
        // http://127.0.0.1:8000/api/get-dishes?visible=all
        else {
            if ($request->query('visible') == 'all') {  //se il parametro visible è impostato a all , vogliamo tutti i piatti di un ristorante, anche quelli non visibili
                $dishes = Dish::with('restaurant')->paginate(10);
            } else {
                $dishes =  Dish::with('restaurant')
                    ->where('visible', true)
                    ->paginate(10);
            }
        }

        if ($dishes) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $dishes
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'error'
                ],
                400
            );
        }
    }

    // http://127.0.0.1:8000/api/get-dishes/ristorante-onisto-noodles-alla-pechinese
    public function findSingleDish($slug)
    {
        $dish = Dish::where('slug', $slug)
            ->with(['restaurant', 'orders'])
            ->where('visible', true)
            ->first();

        if ($dish) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $dish
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Nessun Piatto Trovato'
                ],
                400
            );
        }
    }
}
