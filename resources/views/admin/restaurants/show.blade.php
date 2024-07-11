@section('title', "Dettagli Ristorante: $restaurant->title")
@extends('layouts.admin')


@section('content')
<section class="container py-5">

    <div class="container overflow-hidden example-color" id="details-resturant">
        <div class="row">
            <div class="col-12 p-0">
                <!-- img ristorante -->
                <img class="img-fluid img-show-resturant"
                    src="{{ strpos($restaurant->image, 'http') !== false ? $restaurant->image : asset('storage/' . $restaurant->image) }}"
                    alt="{{ $restaurant->name }}">
            </div>
        </div>
        <div class="row p-3">
            <div class="col-12 col-md-5">
                <!-- title -->
                <h1 class="text-left fw-bolder">Scheda di riepilogo ristorante</h1>
            </div>
            <div class="col-12 col-md-7">
                <h3>Nome Ristorante</h3>
                <p class="mb-4 lead">{{ $restaurant->name }}</p>
                <h3>Indirizzo Ristorante</h3>
                <p class="mb-4 lead">{{ $restaurant->address }}</p>
                <h3>Partita IVA</h3>
                <p class="mb-4 lead">{{ $restaurant->VAT }}</p>
                <h3>Tipologie</h3>
                <div class="d-flex">
                    @foreach ($typologies as $typology)
                        <div class="row gap-2">
                            <div class="svg-container debug" style="width: 100px; aspect-ratio: 1/1">{!! $typology->icon !!}
                            </div>
                            <div class="badge text-bg-secondary" style="background-color:{{ $typology->color }} !important">
                                {{ $typology->name }}
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row gap-3 p-3">
            <div class="d-flex justify-content-center align-items-center mt-auto">
                <a class="btn btn-light" href="{{ route('admin.dashboard', Auth::user()->slug) }}">
                    Torna alla HomePage
                </a>
            </div>
        </div>
    </div>


</section>
@endsection