<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Typology;
use App\Models\User;

use App\Functions\Helpers;
use Carbon\Carbon;


class RestaurantController extends Controller
{
    public function findRestaurants(Request $request)
    {

        //pass array of typologies get all restaurants with that typologies (prova con ctrl+click su endpoint)
        // 1- http://127.0.0.1:8000/api/get-restaurants?typology=cinese                   ------          ottieni tutti i ristoranti di tipo cinese
        // 2- http://127.0.0.1:8000/api/get-restaurants?typology=cinese,pesce            --------         ottieni tutti i ristoranti di tipo cinese || pesce
        // 3- http://127.0.0.1:8000/api/get-restaurants?typology=cinese,pesce&match=all    -------        ottieni tutti i ristoranti di tipo cinese && pesce
        if ($request->query('typology')) {
            $typologies = explode(',', $request->query('typology')); //recupero le tiplogie e le inserisco all'interno di un array

            $matchType = $request->query('match', 'any'); //se la query ha il parametro match lo assegno altrimenti lo imposto ad an di default

            $restaurantsQuery = Restaurant::with(['user', 'typologies', 'dishes']); //assegno ad una variabile il comando di prendere anche i valori di user typologies e dishes, 
            //ATTENZIONE: questo non recupera i ristoranti (si noti l'assenza di all(), get(), o pgainate()) semplicmente dice che datai dovranno avere i ristoranti dopo le query al db

            if ($matchType === 'all') {  //se il parametro match è impostato a all (vedi 3 caso sopra), vogliamo tutti i ristoranti con tutte le tipologie specificate
                $restaurantsQuery = $restaurantsQuery->whereHas('typologies', function ($query) use ($typologies) {
                    $query->whereIn('slug', $typologies);
                }, '=', count($typologies));
            } else {  //se il parametro match non è impostato, sarà di default any vogliamo tutti i ristoranti con tutte le tipologie specificate
                $restaurantsQuery = $restaurantsQuery->whereHas('typologies', function ($query) use ($typologies) {
                    $query->whereIn('slug', $typologies);
                });
            }

            //infine otteniamo i risultati dal db
            $restaurants = $restaurantsQuery->paginate(10);
        }


        //http://127.0.0.1:8000/api/get-restaurants?user-slug=tonino-marino
        else if ($request->query('user-slug')) {

            $userSlug = $request->query('user-slug');
            $user = User::where('slug', $userSlug)->first();
            $restaurants = Restaurant::where('user_id', $user->id)->with('user', 'typologies', 'dishes')->paginate(10);
        }


        //http://127.0.0.1:8000/api/get-restaurants
        else {
            $restaurants = Restaurant::with('user', 'typologies', 'dishes')->paginate(10);
        }



        if ($restaurants) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $restaurants
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Nessun Ristorante Trovato'
                ],
                400
            );
        }
    }

    public function findSingleRestaurant($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->with('user', 'typologies', 'dishes')
            ->get();

        if ($restaurant) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $restaurant
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Nessun Ristorante Trovato'
                ],
                400
            );
        }
    }
}
