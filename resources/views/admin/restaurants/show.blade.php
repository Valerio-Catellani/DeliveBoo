@section('title', "Dettagli Ristorante: $restaurant->title")
@extends('layouts.admin')



@section('content')
    <section class="container py-5">

        <div class="container rounded-2 hype-shadow-white p-0 overflow-hidden example-color">
            <div style="height: 300px" class="overflow-hidden position-relative">
                <img class="img-fluid w-100" style="transform: translateY(-50%)"
                    src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}">
                <div class="position-absolute bottom-0 w-100 h-25 background-gradient-from-bottom-black-to-transparent"
                    style=" ">
                </div>
            </div>
            <h1 class="text-center hype-text-shadow text-white fw-bolder my-3">Dettagli Ristorante: {{ $restaurant->name }}
            </h1>
            <div class="container">
                <div class="row gap-3 p-3">
                    <div class="col-5 p-0 hype-shadow-white">
                        <img class="img-fluid w-100 h-100" src="{{ asset('storage/' . $restaurant->image) }}"
                            alt="{{ $restaurant->name }}">
                    </div>
                    <div class="col-6 d-flex flex-column text-white">
                        <h3>Nome Ristorante</h3>
                        <h5 class="mb-4">{{ $restaurant->name }}</h5>
                        <h3>Indirizzo Ristorante</h3>
                        <h5 class="mb-4">{{ $restaurant->address }}</h5>
                        <h3>Partita IVA</h3>
                        <h5 class="mb-4">{{ $restaurant->VAT }}</h5>
                        <div class="d-flex justify-content-center align-items-center gap-5 mt-auto">
                            <a href="{{ route('admin.dashboard') }}">
                                <i role="button" type="submit"
                                    class="fa-solid fa-arrow-left fs-1 text-white hype-text-shadow hype-hover-size"></i>
                            </a>
                            {{-- <a href="{{ route('admin.restaurants.edit', $restaurant->slug) }}">
                                <i role="button" type="submit"
                                    class="fa-solid fa-pen-to-square fs-1 text-active-tertiary hype-text-shadow hype-hover-size"></i>
                            </a>
                            <form id="delete-form" action="{{ route('admin.restaurants.destroy', $restaurant->slug) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="element-delete default-button text-active-primary hype-text-shadow fs-1"
                                    type="submit" data-element-id="{{ $restaurant->id }}"
                                    data-element-title="{{ $restaurant->name }}">
                                    <i class="fa-solid fa-trash-can "></i>
                                </button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 
        @foreach ($groupedProjections as $day => $projections)
            <div id="{{ $day }}" class="date-section my-5">
                <h2 class="pt-5">Tutte le proiezioni per il giorno: {{ \Carbon\Carbon::parse($day)->format('d/m/Y') }}
                </h2>
                @foreach ($projections as $projection)
                    @include('partials.table-restricted-projection', $projections)
                @endforeach
                @if ($projections->count() < $slots->count())
                    <form method="get" action="{{ route('admin.projections.create') }}">
                        <input type="hidden" name="restaurant_id" value="{{ $room->id }}">
                        <input type="hidden" name="date" value="{{ $day }}">
                        <button type="submit" class="mine-custom-btn mb-3">Aggiungi una Proiezione per il giorno:
                            {{ \Carbon\Carbon::parse($day)->format('d/m/Y') }}</button>
                    </form>
                @endif
            </div>
        @endforeach --}}

        {{-- @foreach ($projections as $projection)
            @include('partials.table-slot-room-projection-movie', ['projection' => $projection])
        @endforeach --}}

    </section>
@endsection
