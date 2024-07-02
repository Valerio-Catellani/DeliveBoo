@section('title', 'Admin Dashboard')
@extends('layouts.admin')

@section('content')
    @php
        $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    @endphp
    <section id="dashboard" data-user-id="{{ Auth::user()->id }}">

        @if ($restaurant)
            <div id="restaurant-dashboard" class=" mx-auto p-5 d-flex flex-column gap-5">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-xxl-6">
                            <div class="card card-custom bg-white border-white border-0 h-100">
                                @if (isset($restaurant->image) && strpos($restaurant->image, 'http') === 0)
                                    <div class="card-custom-img" style="background-image: url('{{ $restaurant->image }}');">
                                    </div>
                                @else
                                    <div class="card-custom-img"
                                        style="background-image: url('{{ asset('storage/' . $restaurant->image) }}');">
                                    </div>
                                @endif
                                <div class="card-body" style="overflow-y: auto">
                                    <h1 class="card-title display-6 mb-1">{{ $restaurant->name }}</h1>
                                    <p>Proprietario: {{ $restaurant->user->name }}</p>
                                    <hr>
                                    <p>Resoconto Amministrativo per il mese: <span id='current_month'
                                            class="fw-bold"></span></p>
                                    <h5 id='total_price' class="card-subtitle mb-3"></h5>
                                    <h5 id='total_ordinations' class="card-subtitle mb-3"></h5>
                                    <hr>
                                    <p>Effettua una ricerca per mese:</p>
                                    <input type="month" id="chartjs-date-picker" value="{{ date('Y-m') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xxl-6">
                            <p class="text-center fst-italic">Distribuzione Ordinazione Piatti</p>
                            <div class="loader-container d-flex justify-content-center">
                                @include('partials.loader')
                            </div>
                            <div class="w-100"><canvas id="acquisitions-donat" class="chart"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xxl-6 mx-auto">
                        <p class="text-center fst-italic">Entrate Giornaliere</p>
                        <div class="loader-container d-flex justify-content-center">
                            @include('partials.loader')
                        </div>
                        <div class="w-100"><canvas id="acquisitions-line" class="chart"></canvas></div>
                    </div>
                    <div class="col-12 col-xxl-6 mx-auto">
                        <p class="text-center fst-italic">Ordini Giornalieri</p>
                        <div class="loader-container d-flex justify-content-center">
                            @include('partials.loader')
                        </div>
                        <div class="w-100"><canvas id="acquisitions" class="chart"></canvas></div>
                    </div>
                </div>
            </div>
            </div>
        @else
            <a role="button" class="mine-custom-btn m-3"
                href="{{ route('admin.restaurants.create', ['user_slug' => Auth::user()->slug]) }}">Aggiungi il tuo primo
                ristorante</a>
        @endif
    </section>
@endsection
