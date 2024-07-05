@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="registration-card" class="card my-4">
                    <div class="card-header display-6 fw-bold">Registrazione Nuovo Utente</div>
                    <div class="card-body">
                        <div class="alert fw-light" role="alert">
                            
                            <span>*</span> I campi contrassegnati sono obbligatori.
                        </div>
                        <div class="user-registration">
                            <form id="registration-form" method="POST" action="{{ route('register') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Nome<span
                                            class="text-white fw-light"> *</span>
                                    </label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="lastname" class="col-md-4 col-form-label text-md-right">Cognome<span
                                    class="text-white fw-light"> *</span></label>

                                    <div class="col-md-6">
                                        <input id="lastname" type="text"
                                            class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                            value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                        @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Indirizzo
                                        Email<span class="text-white fw-light"> *</span></label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password<span
                                    class="text-white fw-light"> *</span></label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Conferma
                                        Password<span class="text-white fw-light"> *</span></label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                        </div>

                        <h1 class="display-6 fw-bold">Aggiungi un Ristorante</h1>
                        <hr>

                        <div class="mb-3 @error('rest_name') err-animation @enderror">

                            <label for="rest_name" class="form-label">Nome<span class="text-white fw-light"> *</span></label>
                            <input type="text"
                                class="form-control @error('rest_name') is-invalid err-animation @enderror" id="rest_name"
                                name="rest_name" value="{{ old('rest_name') }}" required maxlength="255" minlength="3">
                            @error('rest_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 @error('address') err-animation @enderror">
                            <label for="address" class="form-label ">Indirizzo Ristorante<span
                                    class="text-danger fw-bold"> *</span></label>
                            <input type="text" class="form-control @error('address') is-invalid err-animation @enderror"
                                id="address" name="address" value="{{ old('address') }}" required maxlength="255"
                                minlength="3">

                            @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 @error('VAT') err-animation @enderror">

                            <label for="VAT" class="form-label">Partita IVA<span class="text-white fw-light"> *</span></label>
                            <input type="text" class="form-control @error('VAT') is-invalid err-animation @enderror"
                                id="VAT" name="VAT" value="{{ old('VAT') }}" required pattern="\d{11}"
                                title="La partita IVA deve essere esattamente di 11 cifre">
                            @error('VAT')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-5 @error('phone') err-animation @enderror">
                            <label for="phone" class="form-label">Recapito Telefonico</label>
                            <input type="text" class="form-control @error('phone') is-invalid err-animation @enderror"
                                id="phone" name="phone" value="{{ old('phone') }}" maxlength="10"
                                minlength="10" pattern="\d{10}" title="il numero di telefono deve essere di 10 cifre">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-5">
                            <label for="typology_id" class="form-label">
                                Tipologie<span class="text-white fw-light"> *</span>
                                <p class="small mb-0">Puoi selezionarne più d'una</p>
                            </label>
                            <div id="typology_id">
                                @foreach ($typologies as $typology)
                                    <div class="form-check form-check-inline ">
                                        <input class="form-check-input typologies-input" type="checkbox"
                                            name="typologies[]" id="inlineCheckbox-{{ $typology->id }}"
                                            value="{{ $typology->id }}"
                                            {{ in_array($typology->id, old('typologies', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="inlineCheckbox-{{ $typology->id }}">{{ $typology->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('typologies')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-5 @error('image') err-animation @enderror">
                            <label for="image" class="form-label">Immagine Ristorante</label>
                            <div class="d-flex gap-5 align-items-center rounded-2">
                                <div class="w-25 text-center">
                                    <img id="uploadPreview" class="w-100 rounded-4 uploadPreview" width="100"
                                        src="/images/placeholder.png" alt="preview">
                                </div>
                                <div class="w-75">
                                    <input type="file" accept="image/*" class="form-control upload_image"
                                        name="image" value="{{ old('image') }}" >
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-2 mx-auto d-flex justify-content-center">
                            <button id="register-user-button" type="submit" class="mine-custom-btn mb-3 w-100">
                                Registrati
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
