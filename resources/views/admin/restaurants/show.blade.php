@section('title', "Dettagli Ristorante: $restaurant->title")
@extends('layouts.admin')


@section('content')
    <section class="container py-5">

        <div class="container rounded-2 hype-shadow-white p-0 overflow-hidden example-color">
            <div style="height: 300px" class="overflow-hidden position-relative">

                <img class="img-fluid w-100" style="transform: translateY(-50%)"
                    src="{{ strpos($restaurant->image, 'http') !== false ? $restaurant->image : asset('storage/' . $restaurant->image) }}"
                    alt="{{ $restaurant->name }}">
                <div class="position-absolute bottom-0 w-100 h-25 background-gradient-from-bottom-black-to-transparent"
                    style=" ">
                </div>
            </div>
            <h1 class="text-center hype-text-shadow text-white fw-bolder my-3">Dettagli Ristorante: {{ $restaurant->name }}
            </h1>
            <div class="container">
                <div class="row gap-3 p-3">
                    <div class="col-5 p-0 hype-shadow-white">

                        <img class="img-fluid w-100 h-100"
                            src="{{ strpos($restaurant->image, 'http') !== false ? $restaurant->image : asset('storage/' . $restaurant->image) }}"
                            alt="{{ $restaurant->name }}">
                    </div>
                    <div class="col-6 d-flex flex-column text-white">
                        <h3>Nome Ristorante</h3>
                        <h5 class="mb-4">{{ $restaurant->name }}</h5>
                        <h3>Indirizzo Ristorante</h3>
                        <h5 class="mb-4">{{ $restaurant->address }}</h5>
                        <h3>Partita IVA</h3>
                        <h5 class="mb-4">{{ $restaurant->VAT }}</h5>
                        <h3>Tipologie</h3>
                        @foreach ($typologies as $typology)
                            <h2><span class="badge text-bg-secondary"
                                    style="background-color:{{ $typology->color }} !important">{{ $typology->name }}</span>
                            </h2>
                        @endforeach
                        <div class="d-flex justify-content-center align-items-center gap-5 mt-auto">
                            <a class="btn btn-light" href="{{ route('admin.dashboard', session('user_slug')) }}">
                                Torna alla HomePage
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
