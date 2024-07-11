@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="registration-card" class="card my-4">
                    <div class="card-header display-6 fw-bold">Registrazione Nuovo Utente</div>
                    <div class="card-body">
                        <div class="alert fw-light" role="alert">
                        </div>
                        <div class="user-registration">
                            <form id="registration-form" method="POST" action="{{ route('register') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3 @error('name') err-animation @enderror">
                                    <label for="name" class="form-label">Nome<span class="text-white fw-light">
                                            *</span></label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid err-animation @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required
                                        autocomplete="name" autofocus>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 @error('lastname') err-animation @enderror">
                                    <label for="lastname" class="form-label">Cognome<span class="text-white fw-light">
                                            *</span></label>
                                    <input type="text"
                                        class="form-control @error('lastname') is-invalid err-animation @enderror"
                                        id="lastname" name="lastname" value="{{ old('lastname') }}" required
                                        autocomplete="lastname" autofocus>
                                    @error('lastname')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 @error('email') err-animation @enderror">
                                    <label for="email" class="form-label">Indirizzo E-Mail<span
                                            class="text-white fw-light">
                                            *</span></label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid err-animation @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required
                                        autocomplete="email">
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 @error('password') err-animation @enderror">
                                    <label for="password" class="form-label">Password<span class="text-white fw-light">
                                            *</span></label>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid err-animation @enderror"
                                        id="password" name="password" value="{{ old('password') }}" required
                                        autocomplete="new-password">
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 @error('password_confirmation') err-animation @enderror">
                                    <label for="password_confirmation" class="form-label">Conferma Password<span
                                            class="text-white fw-light">
                                            *</span></label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid err-animation @enderror"
                                        id="password-confirm" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                                    @error('password_confirmation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                        </div>

                        <h1 class="display-6 fw-bold">Aggiungi un Ristorante</h1>
                        <hr>

                        <div class="mb-3 @error('rest_name') err-animation @enderror">

                            <label for="rest_name" class="form-label">Nome<span class="text-white fw-light">
                                    *</span></label>
                            <input type="text"
                                class="form-control @error('rest_name') is-invalid err-animation @enderror" id="rest_name"
                                name="rest_name" value="{{ old('rest_name') }}" required maxlength="255" minlength="3">
                            @error('rest_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 @error('address') err-animation @enderror">
                            <label for="address" class="form-label ">Indirizzo<span class="text-white fw-bold">
                                    *</span></label>
                            <input type="text" class="form-control @error('address') is-invalid err-animation @enderror"
                                id="address" name="address" value="{{ old('address') }}" required maxlength="255"
                                minlength="3">

                            @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 @error('VAT') err-animation @enderror">

                            <label for="VAT" class="form-label">Partita IVA<span class="text-white fw-light">
                                    *</span></label>
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



                        <div class="mb-5 @error('image') err-animation @enderror d-flex gap-5 align-items-center">
                            <div class="w-25 text-center">
                                <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                    src="{{ old('image', '/images/placeholder.png') }}" alt="preview">
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

                        <div class="mb-2 mx-auto d-flex justify-content-center">
                            <button id="register-user-button" type="submit" class="btn register-btn mb-3">
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
