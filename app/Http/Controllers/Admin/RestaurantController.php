<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use App\Http\Controllers\Controller;
use App\Functions\Helpers;
use App\Http\Requests\StoreRestaurantRequest;
use App\Models\User;
use App\Models\Typology;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('admin.dashboard', ['user_slug' => Auth::user()->slug]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurant = Restaurant::where('user_id', Auth::user()->id)->first();
        $typologies = Typology::all();
        if ($restaurant) {
            $data = [
                'user_slug' => Auth::user()->slug,
                'restaurant_slug' => $restaurant->slug,
                'typologies' => $typologies
            ];
            return redirect()->route('admin.restaurants.show',  $data);
        } //se l'utente prova a fare il furbo e ad entrare manualmente dentro la create
        return view('admin.restaurants.create', compact('typologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        
        $validate = $request->validated();

        $validate['slug'] = Helpers::generateSlug($validate['name'], Restaurant::class);
        $validate['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $img_path = Storage::put('image', $request->image);
            $validate['image'] = $img_path;
        } else {
            $validate['image'] = 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png';
        }

        $new_restaurant = new Restaurant();
        $new_restaurant->fill($validate);
        $new_restaurant->save();

        if ($request->has('typologies')) {
            $new_restaurant->typologies()->attach($request->typologies);
        }

        $data = [
            'user_slug' => Auth::user()->slug,
            'restaurant_slug' => $new_restaurant->slug,
            'typologies' => $new_restaurant->typologies
        ];
        return redirect()->route('admin.restaurants.show', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_slug, $restaurant_slug)
    {


        $restaurant = Restaurant::where('slug', $restaurant_slug)->first();
        if ($restaurant && $restaurant->user_id == Auth::user()->id) {

            $data = [
                'user_slug' => $user_slug,
                'restaurant' => $restaurant,
                'typologies' => $restaurant->typologies
            ];

            return view('admin.restaurants.show', $data);
        }

        return view('admin.errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}
