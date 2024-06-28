<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use App\Http\Controllers\Controller;
use App\Functions\Helpers;
use App\Models\User;
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
        if ($restaurant) {
            return redirect()->route('admin.restaurants.show',  $restaurant->slug);
        } //se l'utente prova a fare il furbo e ad entrare manualmente dentro la create
        return view('admin.restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
            'VAT' => 'required|string|size:11',
        ], [
            'name.required' => 'Il nome è obbligatorio',
            'name.min' => 'Il nome deve avere almeno 3 caratteri',
            'name.max' => 'Il nome deve avere massimo 255 caratteri',
            'address.required' => 'L\'indirizzo è obbligatorio',
            'address.min' => 'L\'indirizzo deve avere almeno 3 caratteri',
            'address.max' => 'L\'indirizzo deve avere massimo 255 caratteri',
            'VAT.required' => 'Il codice fiscale è obbligatorio',
            'VAT.size' => 'Il codice fiscale deve avere 11 caratteri',
        ]);

        $validate['slug'] = Helpers::generateSlug($validate['name'], Restaurant::class);


        $validate['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $img_path = Storage::put('image', $request->image);
            $validate['image'] = $img_path;
        }

        $new_restaurant = new Restaurant();
        $new_restaurant->fill($validate);
        $new_restaurant->save();

        $data = [
            'restaurant_slug' => $new_restaurant->slug,
            'user_slug' => Auth::user()->slug
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
            return view('admin.restaurants.show', compact('restaurant'));
        }

        return redirect()->route('admin.dashboard', ['user_slug' => $user_slug]);
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
