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
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="d-flex flex-column mb-3 align-items-baseline">
            <h2 class="text-center hype-text-shadow display-3 fw-bold title-primary my-3 w-100">Piatti del
                {{ $restaurant->name }}</h2>
            <button class="btn btn-success hype-hover-size my-3"
                onclick="location.href='{{ route('admin.dishes.create', $data) }}'">
                <i class="fa-solid fa-plus"></i> Aggiungi Piatto
            </button>
        </div>
        @if ($dishes && count($dishes) > 0)
            <table class="table table-bordered table-striped text-center hype-unselectable">
                <thead>
                    <tr>
                        <th class="col-2 d-none d-xl-table-cell">Immagine</th>
                        <th>Nome</th>
                        <th>Prezzo</th>
                        <th class="d-none d-xl-table-cell">Visibile</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dishes as $dish)
                        @php
                            if ($restaurant) {
                                $data_dish_slug = [
                                    'restaurant_slug' => $restaurant->slug,
                                    'user_slug' => $user->slug,
                                    'dish_slug' => $dish->slug,
                                ];
                            }
                        @endphp
                        <tr>
                            <td class="align-middle d-none d-xl-table-cell {{ $dish->visible ? '' : 'opacity-50' }}">
                                @if (isset($dish->image) && strpos($dish->image, 'http') === 0)
                                    <img src="{{ $dish->image }}" class="img-fluid" alt="dish image"
                                        style="height: 200px; width:200px">
                                @elseif (isset($dish->image) && !is_null($dish->image))
                                    <img src="{{ asset('storage/' . $dish->image) }}" class="img-fluid" alt="dish image"
                                        style="height: 200px; width:200px">
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" class="img-fluid" alt="no image"
                                        >
                                @endif
                            </td>
                            <td class="align-middle {{ $dish->visible ? '' : 'opacity-50' }}">{{ $dish->name }}</td>
                            <td class="align-middle {{ $dish->visible ? '' : 'opacity-50' }}">{{ $dish->price }}€</td>
                            <td class="align-middle d-none d-xl-table-cell {{ $dish->visible ? '' : 'opacity-50' }}">
                                {{ $dish->visible ? 'Si' : 'No' }}</td>
                            <td class="align-middle {{ $dish->visible ? '' : 'bg-opacity-50' }}">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-warning hype-hover-size"
                                        onclick="location.href='{{ route('admin.dishes.edit', $data_dish_slug) }}'">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <form id="delete-form" action="{{ route('admin.dishes.destroy', $data_dish_slug) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger element-delete hype-hover-size" type="submit"
                                            data-element-id="{{ $dish->id }}"
                                            data-element-title="{{ $dish->name }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 50vh;">
                <p class="text-center">Nessun piatto presente</p>
                <button class="btn btn-success mt-2" onclick="location.href='{{ route('admin.dishes.create', $data) }}'">
                    <i class="fa-solid fa-plus"></i> Aggiungi il primo piatto
                </button>
            </div>
        @endif
    </section>
@endsection