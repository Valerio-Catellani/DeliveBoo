@php
    $restaurant = App\Models\Restaurant::where('user_id', Auth::user()->id)->first();
    $user = Auth::user();
    if ($restaurant) {
    $data = [
        'restaurant_slug' => $restaurant->slug,
        'user_slug' => $user->slug,
    ];
    };
@endphp

@section('title', "Dettagli Ristorante: ")
@extends('layouts.admin')



@section('content')

<section class="container py-5">

    <div class="container rounded-2 hype-shadow-white p-0 overflow-hidden example-color">
    @if($dishes)    
    <ul>
            @foreach($dishes as $dish)
            <li>{{ $dish->name }}</li>
            @endforeach
        </ul>
        
        @else
        <p>Non ci sono piatti nel ristorante</p>
        @endif
        <a href="{{ route('admin.dishes.create', $data) }}">
            <div class="btn btn-primary">Crea Nuovo Piatto</div>
        </a>
        
    </div>

</section>
@endsection