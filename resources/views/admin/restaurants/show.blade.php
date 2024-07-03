@section('title', "Dettagli Ristorante: $restaurant->title")
@extends('layouts.admin')


@section('content')
<section class="container py-5">

    <div class="container overflow-hidden example-color" id="details-resturant">
        <div class="row">
            <div class="col-12 img-show-resturant">
                <!-- img ristorante -->
                <img class="img-fluid"
                    src="{{ strpos($restaurant->image, 'http') !== false ? $restaurant->image : asset('storage/' . $restaurant->image) }}"
                    alt="{{ $restaurant->name }}">
            </div>
        </div>
        <div class="row p-3">
            <div class="col-12 col-md-5">
                <!-- title -->
                <h1 class="text-left fw-bolder my-3">Scheda di riepilogo ristorante</h1>
            </div>
            <div class="col-12 col-md-7">
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
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row gap-3 p-3">

            <div class="col-6 d-flex flex-column text-white">

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