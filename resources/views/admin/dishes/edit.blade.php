
@php
    $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    $user = Auth::user();
    if ($restaurant) {
    $data = [
        'restaurant_slug' => $restaurant->slug,
        'user_slug' => $user->slug,
        'dish_slug' => $dish->slug 

    ];
    };
@endphp

@section('title', 'Aggiungi un nuovo piatto')
@extends('layouts.admin')

@section('content')
    <section class="container py-5">


        <div class="container rounded-2 hype-shadow-white p-5 container-table example-color">
            <h1 class="text-center hype-text-shadow text-white fw-bolder">Modifica piatto</h1>

            <form id="comic-form" action="{{ route('admin.dishes.update', $data) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3 @error('name') err-animation @enderror">
                    <label for="name" class="form-label text-white">Nome piatto</label>
                    <input type="text" class="form-control @error('name') is-invalid err-animation @enderror"
                        id="name" name="name" value="{{ $dish->name }}" required maxlength="255" >
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 @error('ingredients') err-animation @enderror">
                    <label for="ingredients" class="form-label text-white">Ingredienti</label>
                    <textarea class="form-control @error('ingredients') is-invalid err-animation @enderror"
                        id="ingredients" name="ingredients" rows="3">{{ $dish->ingredients }}</textarea>
                    @error('ingredients')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('visible') err-animation @enderror">
                    <label for="visible" class="form-label text-white">Visibile</label>
                    <div class="form-check">
                    <input type="checkbox" id="visible" name="visible" value="1">
                    @error('visible')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                

                 <div class="mb-3 @error('description') err-animation @enderror">
                    <label for="description" class="form-label text-white">Descrizione</label>
                    <textarea class="form-control @error('description') is-invalid err-animation @enderror"
                        id="description" name="description" rows="3">{{ $dish->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('price') err-animation @enderror">
                    <label for="price" class="form-label text-white">Prezzo</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid err-animation @enderror"
                        id="price" name="price" value="{{ $dish->price }}" required>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="w-75">
                        <label for="image" class="form-label text-white">Immagine Piatto</label>
                        <input type="file" accept="image/*" class="form-control upload_image" name="image"
                            value="{{ $dish->image }}">
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
                <br>
                <div class="text-center w-25 mx-auto d-flex gap-2">
                    <button type="submit" class="mine-custom-btn mt-3 w-100">Salva</button>
                    <!-- <a href="{{ route('admin.dashboard', ['user_slug' => session('user_slug')]) }}"
                        class="mine-custom-btn min-custom-btn-grey mt-3 w-100">Indietro</a> -->
                </div>

            </form>
        </div>

    </section>
@endsection
