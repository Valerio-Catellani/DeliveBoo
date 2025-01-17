@section('title', 'Dashboard')
@extends('layouts.admin')

@section('content')
    @php
        $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    @endphp
    <section id="dashboard" data-user-id="{{ Auth::user()->id }}">

        @if ($restaurant)
            <div id="restaurant-dashboard" class=" mx-auto d-flex flex-column gap-5">
                <div class="container">
                    <h2 class=" display-3 fw-bold title-primary mb-5 my-2 w-100">Benvenuto
                        <strong>{{ Auth::user()->name }}
                            {{ Auth::user()->lastname }}</strong>
                    </h2>
                    <div class="row ">
                        <div class="col-12 col-xl-6">
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
                                    <p>Proprietario: {{ $restaurant->user->name }} {{ $restaurant->user->lastname }}</p>
                                    <div id="total_price_year" class="fs-4"></div>
                                    <div id="total_ordinations_year" class="fs-4"></div>
                                    <hr>
                                    <p>Resoconto Amministrativo per il mese: <span class="fw-bold current_month"></span>
                                    </p>
                                    <h6 id='total_price' class="card-subtitle mb-3"></h6>
                                    <h6 id='total_ordinations' class="card-subtitle mb-3"></h6>
                                    <hr>
                                    <label for="chartjs-date-picker">Effettua una ricerca per mese: </label>
                                    <input type="month" id="chartjs-date-picker" value="{{ date('Y-m') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6 mt-xxl-0">
                            <p class="text-center fs-3 fst-italic fst-italic-update mt-5 mt-md-0">Piatti più ordinati per il
                                mese
                                di
                                <span class="fw-bold current_month"></span>
                            </p>
                            <div class="loader-container d-flex justify-content-center">
                                @include('partials.loader')
                            </div>
                            <div id="dishes-table">
                            </div>
                        </div>
                    </div>
                    <div class="row  py-0 py-md-5">
                        <div class="col-12 col-md-6 mx-auto my-5 my-md-0 mt-xxl-1">
                            <p class="text-center fs-3 fst-italic fst-italic-update">Entrate Giornaliere per il mese di
                                <span class="fw-bold current_month"></span>
                            </p>
                            <div class="loader-container d-flex justify-content-center">
                                @include('partials.loader')
                            </div>
                            <div class="w-100"><canvas id="acquisitions-line" class="chart chart-to-update"></canvas></div>
                        </div>
                        <div class="col-12 col-md-6 mx-auto mb-5 mt-xxl-1">
                            <p class="text-center fs-3 fst-italic fst-italic-update">Ordini Giornalieri per il mese di <span
                                    class="fw-bold current_month"></span></p>
                            <div class="loader-container d-flex justify-content-center">
                                @include('partials.loader')
                            </div>
                            <div class="w-100"><canvas id="acquisitions" class="chart chart-to-update"></canvas></div>
                        </div>
                    </div>
                    <div class="row py-2">
                        <div class="col-12 mx-auto my-3 mt-xxl-1">
                            <p class="text-center fs-1 fst-italic">Entrate Annuali</p>
                            <div class="loader-container d-flex justify-content-center">
                            </div>
                            <div class="w-100"><canvas id="acquisitions-line-Year" class="chart"></canvas></div>
                        </div>
                        <div class="col-12 mx-auto mt-5 mt-xxl-1">
                            <p class="text-center fs-1 fst-italic">Ordini Annuali</p>
                            <div class="loader-container d-flex justify-content-center">
                            </div>
                            <div class="w-100"><canvas id="acquisitionsYear" class="chart"></canvas></div>
                        </div>
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
