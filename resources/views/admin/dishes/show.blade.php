@php
    $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    $user = Auth::user();
    if ($restaurant) {
        $data = [
            'restaurant_slug' => $restaurant->slug,
            'user_slug' => $user->slug,
            'dish_slug' => $dish->slug,
        ];
    }
@endphp

@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')

@section('content')
    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-center hype-text-shadow display-3 fw-bold title-primary my-3 w-100">Piatto del
                {{ $restaurant->name }}</h2>
        </div>
        <div class="card card-custom">
            @if (isset($dish->image) && strpos($dish->image, 'http') === 0)
                <img src="{{ $dish->image }}" class="card-img-top " alt="{{ $dish->name }}">
            @else
                <img src="{{ asset('storage/' . $dish->image) }}" class="card-img-top" alt="{{ $dish->name }}">
            @endif
            <div class="card-body">
                <h2 class="card-title fs-2 fw-bold"><span class="fw-bold">Nome: </span>{{ $dish->name }}</h2>
                <hr>
                <p class="card-text fs-4"><span class="fw-bold">Descrizione: </span>{{ $dish->description }}</p>
                <p class="card-text fs-4"><span class="fw-bold">Ingredienti: </span>{{ $dish->ingredients }}</p>
                <p class="card-text fs-4"><span class="fw-bold">Prezzo:</span> {{ $dish->price }}€</p>
                <div class="button-section d-flex gap-2">
                    <form id="delete-form" action="{{ route('admin.dishes.destroy', $data) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger element-delete" type="submit" data-element-id="{{ $dish->id }}"
                            data-element-title="{{ $dish->name }}">
                            <i class="fa-solid fa-trash"></i> Elimina
                        </button>
                    </form>
                    <button class="btn btn-warning" onclick="location.href='{{ route('admin.dishes.edit', $data) }}'">
                        <i class="fa-solid fa-edit"></i> Modifica
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
