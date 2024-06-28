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
    @if (App\Models\Restaurant::where('user_id', Auth::user()->id)->exists())
        <p>risto</p>
    @else
        <a role="button" class="mine-custom-btn mb-3" href="{{ route('admin.restaurants.create') }}">Aggiungi il tuo Primo
            ristorante</a>
    @endif
@endsection
