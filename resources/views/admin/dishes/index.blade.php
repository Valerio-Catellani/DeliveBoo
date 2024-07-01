@php
    $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    $user = Auth::user();
    if ($restaurant) {
        $data = [
            'restaurant_slug' => $restaurant->slug,
            'user_slug' => $user->slug,
        ];
    }
@endphp

@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')



@section('content')

    <section class="container py-5">

        <div class="container rounded-2 hype-shadow-white p-0 overflow-hidden">
            <h2 class="text-center">Piatti del: {{ $restaurant->name }}</h2>
            @if ($dishes)
                <div class="row gy-5 p-1">
                    @foreach ($dishes as $dish)
                        <div class="col-3">
                            <div class="card card-custom bg-white border-white border-0">
                                @if (isset($dish->image) && strpos($dish->image, 'http') === 0)
                                    <div class="card-custom-img" style="background-image: url('{{ $dish->image }}');">
                                    </div>
                                @else
                                    <div class="card-custom-img"
                                        style="background-image: url('{{ asset('storage/' . $dish->image) }}');">
                                    </div>
                                @endif
                                <div class="card-body" style="overflow-y: auto">
                                    <h3 class="card-title">{{ $dish->name }}</h3>
                                    <p class="card-text">{{ $dish->description }}</p>
                                    <p class="card-text">Prezzo: {{ $dish->price }}€</p>
                                </div>
                                @php
                                    if ($restaurant) {
                                        $data_dish_slug = [
                                            'restaurant_slug' => $restaurant->slug,
                                            'user_slug' => $user->slug,
                                            'dish_slug' => $dish->slug,
                                        ];
                                    }

                                @endphp
                                <div class="card-footer d-flex gap-3" style="background: inherit; border-color: inherit;">
                                    <a href="{{ route('admin.dishes.show', $data_dish_slug) }}"
                                        class="btn btn-primary">Mostra Dettaglio</a>
                                    <form id="delete-form" action="{{ route('admin.dishes.destroy', $data_dish_slug) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="element-delete text-active-primary hype-text-shadow btn btn-danger"
                                            type="submit" data-element-id="{{ $dish->id }}"
                                            data-element-title="{{ $dish->name }}">
                                            Elimina Piatto
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Non ci sono piatti nel ristorante</p>
            @endif
            <a href="{{ route('admin.dishes.create', $data) }}">
                <div class="btn btn-primary">Crea Nuovo Piatto</div>
            </a>
        </div>

    </section>
@endsection
