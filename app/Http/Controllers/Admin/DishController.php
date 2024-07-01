<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreDishRequest;
use App\Models\Dish;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Functions\Helpers;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurant = Restaurant::where('user_id', Auth::user()->id)->first();
        $restaurant_id = $restaurant->id;
        $dishes = Dish::where('restaurant_id', $restaurant_id)->with('restaurant')->get();
        return view('admin.dishes.index', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($user_slug, $restaurant_slug)
    {
        $restaurant = Restaurant::where('slug', $restaurant_slug)->first();

        if ($restaurant->user_id == Auth::user()->id) {
            return view('admin.dishes.create');
        } else {
            return redirect()->route('admin.dashboard', ['user_slug' => Auth::user()->slug]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishRequest $request)
    {
        $data_store = $request->validated();

        $new_dish = new Dish();
        $new_dish->name = $data_store['name'];
        $new_dish->description = $data_store['description'];
        $new_dish->price = $data_store['price'];
        //  $new_dish->image = $data_store['image'];
        $new_dish->ingredients = $data_store['ingredients'];
        //  if($data_store['visible']) {
        //     $new_dish->visible = $data_store['visible'];
        //  }
        $new_dish->restaurant_id = Auth::user()->restaurant->id;
        $new_dish->slug = Helpers::generateSlug($data_store['name'], Dish::class);
        if ($request->hasFile('image')) {
            $name = $request->image->getClientOriginalName();
            $path = Storage::putFileAs('dishes_images', $request->image, $name);
            $new_dish->image = $path;
        }
        $new_dish->save();
        $data = [
            'restaurant_slug' => Auth::user()->restaurant->slug,
            'user_slug' => Auth::user()->slug
        ];
        return redirect()->route('admin.dishes.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_slug, $restaurant_slug, $dish_slug)
    {
        dd($dish_slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        //
    }
}
