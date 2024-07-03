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


class TypologyController extends Controller
{
    public function findTypologies(Request $request)
    {

        // http://127.0.0.1:8000/api/get-typologies

        if ($request->has('restaurant')) {
            $typologies = Typology::with('restaurants')->paginate(10);
        } else {
            $typologies = Typology::paginate(10);
        }
        if ($typologies) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $typologies
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Nessuna tipologia trovata'
                ],
                400
            );
        }
    }
}
