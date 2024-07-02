@section('title', 'Admin Dashboard')
@extends('layouts.admin')

@section('content')
    @php
        $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    @endphp
    <main id="dashboard" data-user-id="{{ Auth::user()->id }}">
        @if ($restaurant)
            <div id="restaurant-dashboard" class="hype-w-80x100 mx-auto py-5 d-flex flex-column gap-5">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6">
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
                                    <h1 class="card-title display-3">{{ $restaurant->name }}</h1>
                                    <h2 id='total_price' class="card-subtitle"></h2>
                                </div>
                                <input type="month" id="datepicker">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="w-100"><canvas id="acquisitions-donat"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="w-100"><canvas id="acquisitions-line"></canvas></div>
                    </div>
                    <div class="col-6 mx-auto">
                        <div class="w-100"><canvas id="acquisitions"></canvas></div>
                    </div>
                </div>
            </div>
            </div>
        @else
            <a role="button" class="mine-custom-btn mb-3"
                href="{{ route('admin.restaurants.create', ['user_slug' => Auth::user()->slug]) }}">Aggiungi il tuo Primo
                ristorante</a>
        @endif
    </main>
@endsection
