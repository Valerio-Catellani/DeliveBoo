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
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center mb-3">
            <h2 class="text-center">Piatti del: {{ $restaurant->name }}</h2>
            <button class="btn btn-success" onclick="location.href='{{ route('admin.dishes.create', $data) }}'">
                <i class="fa-solid fa-plus"></i> Aggiungi Piatto
            </button>
        </div>
        @if ($dishes && count($dishes) > 0)
            <table class="table table-bordered table-striped text-center hype-unselectable">
                <thead>
                    <tr>
                        <th class="col-2 d-none d-xl-table-cell">Immagine</th>
                        <th class="col-2">Nome</th>
                        <th class="col-2 d-none d-xl-table-cell">Descrizione</th>
                        <th class="col-2">Prezzo</th>
                        <th class="col-4">Azioni</th>
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
                            <td class="align-middle d-none d-xl-table-cell">
                                @if (isset($dish->image) && strpos($dish->image, 'http') === 0)
                                    <img src="{{ $dish->image }}" class="img-fluid" alt="dsih image"
                                        style="max-height: 100px;">
                                @else
                                    <img src="{{ asset('storage/' . $dish->image) }}" class="img-fluid" alt="dish image"
                                        style="max-height: 70px;">
                                @endif
                            </td>
                            <td class="align-middle">{{ $dish->name }}</td>
                            <td class="align-middle d-none d-xl-table-cell">{{ $dish->description }}</td>
                            <td class="align-middle">{{ $dish->price }}€</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-primary"
                                        onclick="location.href='{{ route('admin.dishes.show', $data_dish_slug) }}'">
                                        <i class="fa-solid fa-eye"></i> Mostra
                                    </button>
                                    <button class="btn btn-warning"
                                        onclick="location.href='{{ route('admin.dishes.edit', $data_dish_slug) }}'">
                                        <i class="fa-solid fa-edit"></i> Modifica
                                    </button>
                                    <form id="delete-form" action="{{ route('admin.dishes.destroy', $data_dish_slug) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger element-delete" type="submit"
                                            data-element-id="{{ $dish->id }}"
                                            data-element-title="{{ $dish->name }}">
                                            <i class="fa-solid fa-trash"></i> Elimina
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
