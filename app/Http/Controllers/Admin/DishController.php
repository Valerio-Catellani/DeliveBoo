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
        $dishes = Dish::where('restaurant_id', $restaurant_id)->with('restaurant')->orderBy('name', 'asc')->get();
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
            return view('admin.errors.404');
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
        return redirect()->route('admin.dishes.index', $data)->with('message', 'Nuovo piatto: ' . $new_dish->name . ' creato con successo!');
    }

    /**
     * Display the specified resource.
     */

    public function show($user_slug, $restaurant_slug, $dish_slug)
    {
        /* $restaurant = Restaurant::where('slug', $restaurant_slug)->first();

        if ($restaurant->user_id == Auth::user()->id) {

            $dish = Dish::where('slug', $dish_slug)->first();
            return view('admin.dishes.show', compact('dish'));
        } else {
            return view('admin.errors.404');
        } */
        return view('admin.errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($user_slug, $restaurant_slug, $dish_slug)
    {
        $restaurant = Restaurant::where('slug', $restaurant_slug)->first();

        if ($restaurant->user_id == Auth::user()->id) {

            $dish = Dish::where('slug', $dish_slug)->first();
            $data = [
                'restaurant_slug' => Auth::user()->restaurant->slug,
                'user_slug' => Auth::user()->slug,
                'dish_slug' => $dish->slug
            ];

            return view('admin.dishes.edit', compact('dish', 'data'));
        } else {
            return view('admin.errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(StoreDishRequest $request, $user_slug, $restaurant_slug, $dish_slug)
    {

        $data_update = $request->validated();
        $dish = Dish::where('slug', $dish_slug)->first();
        if ($request->hasFile('image')) {
            if ($dish->image) {
                Storage::delete($dish->image);
            }
            $name = $request->image->getClientOriginalName();
            $path = Storage::putFileAs('dishes_images', $request->image, $name);
            $data_update['image'] = $path;
        }
        if (!$request['visible']) {
            $data_update['visible'] = 0;
        }
        $dish->update($data_update);
        $data = [
            'restaurant_slug' => Auth::user()->restaurant->slug,
            'user_slug' => Auth::user()->slug
        ];
        return redirect()->route('admin.dishes.index', $data)->with('message', 'Piatto: "' . $dish->name . '" modificato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($user_slug, $restaurant_slug, $dish_slug)
    {
        $restaurant = Restaurant::where('slug', $restaurant_slug)->first();

        if ($restaurant->user_id == Auth::user()->id) {

            $dish = Dish::where('slug', $dish_slug)->first();
            $dish->delete();
            return redirect()->route('admin.dishes.index', ['user_slug' => Auth::user()->slug, 'restaurant_slug' => $restaurant_slug])->with('message', 'Piatto: "' . $dish->name . '" eliminato con successo!');
        } else {
            return view('admin.errors.404');
        }
    }
}
