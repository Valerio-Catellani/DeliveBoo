@section('title', 'Aggiungi un Ristorante')
@extends('layouts.admin')

@section('content')
    <section class="container py-5">


        <div class="container rounded-2 hype-shadow-white p-5 container-table example-color">
            <h1 class="text-center hype-text-shadow text-white fw-bolder">Aggiungi un Ristorante</h1>

            <form id="comic-form" action="{{ route('admin.restaurants.store', Auth::user()->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-3 @error('name') err-animation @enderror">
                    <label for="name" class="form-label text-white">Nome Ristorante</label>
                    <input type="text" class="form-control @error('name') is-invalid err-animation @enderror"
                        id="name" name="name" value="{{ old('name') }}" required maxlength="255" minlength="3">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('address') err-animation @enderror">
                    <label for="address" class="form-label text-white">Indirizzo Ristorante</label>
                    <input type="text" class="form-control @error('address') is-invalid err-animation @enderror"
                        id="address" name="address" value="{{ old('address') }}" required maxlength="255" minlength="3">
                    @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('VAT') err-animation @enderror">
                    <label for="VAT" class="form-label text-white">Partita IVA</label>
                    <input type="text" class="form-control @error('VAT') is-invalid err-animation @enderror"
                        id="VAT" name="VAT" value="{{ old('VAT') }}" required pattern="\d{11}"
                        title="La partita IVA deve essere esattamente di 11 cifre">
                    @error('VAT')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="typology_id" class="form-label text-white">Seleziona una o più Tipologie</label>
                    <div id="typology_id">
                        @foreach ($typologies as $typology)
                            <div class="form-check form-check-inline text-white">
                                <input class="form-check-input" type="checkbox" name="typologies[]" id="inlineCheckbox1"
                                    value="{{ $typology->id }}"
                                    {{ in_array($typology->id, old('typologies', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="inlineCheckbox1">{{ $typology->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="mb-3 @error('image') err-animation @enderror d-flex gap-5 align-items-center">
                    <div class="w-25 text-center">
                        <img id="uploadPreview" class="w-100 uploadPreview" width="100" src="/images/placeholder.png"
                            alt="preview">
                    </div>
                    <div class="w-75">
                        <label for="image" class="form-label text-white">Immagine Ristorante</label>
                        <input type="file" accept="image/*" class="form-control upload_image" name="image"
                            value="{{ old('image') }}">
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <br>
                <div class="text-center w-25 mx-auto d-flex gap-2">
                    <button type="submit" class="mine-custom-btn mt-3 w-100">Salva</button>
                    <a href="{{ route('admin.dashboard', ['user_slug' => session('user_slug')]) }}"
                        class="mine-custom-btn min-custom-btn-grey mt-3 w-100">Indietro</a>
                </div>
            </form>
        </div>

    </section>
@endsection
