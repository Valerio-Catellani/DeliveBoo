@section('title', 'Admin Dashboard')
@extends('layouts.admin')

@section('content')
    {{-- <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <main id="dashboard">
        @if (App\Models\Restaurant::where('user_id', Auth::user()->id)->exists())
            <div id="restaurant-dashboard" class="container">
                <div class="row">
                    <div class="col col-lg-8">
                        <div class="w-100"><canvas id="acquisitions-line"></canvas></div>
                    </div>
                    <div class="col-4">
                        <input type="month" id="select-date" name="date">

                    </div>
                    <div class="col-8 mx-auto">
                        <div class="w-100"><canvas id="acquisitions"></canvas></div>
                    </div>
                    <div class="col-4 mx-auto">
                        <div class="w-100"><canvas id="acquisitions-donat"></canvas></div>
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
