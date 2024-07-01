@php
    $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    $user = Auth::user();
    if ($restaurant) {
        $data = [
            'restaurant_slug' => $restaurant->slug,
            'user_slug' => $user->slug,
            'dish_slug' => $dish->slug
        ];
    }
@endphp

@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')



@section('content')

    <section class="container py-5">

        <div class="container rounded-2 hype-shadow-white p-0 overflow-hidden">
            
                <div class="row gy-5 p-1">
                    
                        <div class="col-3">
                            <div class="card card-custom bg-white border-white border-0">
                                <div class="card-custom-img" style="background-image: url('{{ $dish->image }}');">
                                </div>
                                <div class="card-body" style="overflow-y: auto">
                                    <h3 class="card-title">{{ $dish->name }}</h3>
                                    <img src="{{ $dish->image }}" alt="{{ $dish->name }}">
                                    <p class="card-text">{{ $dish->description }}</p>
                                    <p class="card-text">Ingredienti: {{ $dish->ingredients }}</p>
                                    <p class="card-text">Prezzo: {{ $dish->price }}€</p>
                                    <p class="card-text">Piatto visibile dal cliente: {{ $dish->visible }}</p>
                                </div>
                               
                                <div class="card-footer" style="background: inherit; border-color: inherit;">
                                    
                                    <form id="delete-form" action="{{ route('admin.dishes.destroy', $data) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="element-delete default-button text-active-primary hype-text-shadow fs-1 btn btn-danger"
                                            type="submit" data-element-id="{{ $dish->id }}"
                                            data-element-title="{{ $dish->name }}">
                                            Elimina Piatto
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    
                </div>
           
            <a href="{{ route('admin.dishes.create', $data) }}">
                <div class="btn btn-primary">Crea Nuovo Piatto</div>
            </a>
            <a href="{{ route('admin.dishes.edit', $data) }}">
                <div class="btn btn-primary">Modifica Piatto</div>
            </a>
        </div>

    </section>
@endsection
