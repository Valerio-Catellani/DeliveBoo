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

@extends('layouts.admin')
@section('title', 'Modifica piatto')

@section('content')
    <section class="container">

        <div class="card-form-main">
            <div class="card-image">
                <h2 class="card-heading text-light">
                    Gestore Menu
                    <small>Modifica una portata</small>
                </h2>
            </div>
            <form id="comic-form" class="card-form" action="{{ route('admin.dishes.update', $data) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fa-solid fa-exclamation-circle me-2"></i>
                    Tutti i campi contrassegnati con <span class="text-danger"> * </span> sono obbligatori.
                </div> -->


                <div class="mb-3 @error('name') err-animation @enderror">
                    <label for="name" class="form-label">Nome piatto <span class="text-danger">*</span></label>
                    <input type="text" class="input-field form-control @error('name') is-invalid err-animation @enderror"
                        id="name" name="name" value="{{ $dish->name }}" required maxlength="255">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('price') err-animation @enderror">
                    <label for="price" class="form-label">Prezzo <span class="text-danger">*</span></label>
                    <input type="number" step="0.01"
                        class="form-control @error('price') is-invalid err-animation @enderror" id="price"
                        name="price" value="{{ $dish->price }}" required>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('ingredients') err-animation @enderror">
                    <label for="ingredients" class="form-label">Ingredienti <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('ingredients') is-invalid err-animation @enderror" id="ingredients"
                        name="ingredients" rows="3">{{ $dish->ingredients }}</textarea>
                    @error('ingredients')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('description') err-animation @enderror">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea class="form-control @error('description') is-invalid err-animation @enderror" id="description"
                        name="description" rows="3">{{ $dish->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3 @error('image') err-animation @enderror">
                    <label for="image" class="form-label">Immagine Piatto</label>
                    <input type="file" accept="image/*" class="form-control upload_image" name="image"
                        value="{{ $dish->image }}">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3 @error('visible') err-animation @enderror">
                    <input type="checkbox" id="visible" name="visible" value="1" class="form-check-input"
                        {{ $dish->visible ? 'checked' : '' }}>
                    <label for="visible" class="form-check-label">Visibile</label>
                    @error('visible')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center w-100 d-flex flex-column gap-2">
                    <button type="submit" class="mine-custom-btn mt-3 w-100">Salva</button>
                </div>
            </form>
        </div>
    </section>
@endsection
