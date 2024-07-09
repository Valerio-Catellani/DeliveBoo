@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')

@section('content')



    @foreach ($orders as $order)
        <div>
            <h1>Numero Ordine: {{ $order->id }}</h1>
            <h2>Nome Utente: {{ $order->customer_name }}</h2>
            @foreach ($order->dishes as $dish)
                <div class="border border-3">
                    <p>Nome Piatto: {{ $dish->pivot->dish_name }}</p>
                    <p>Prezzo Piatto: {{ $dish->pivot->dish_price }}</p>
                    <p>Quantità Piatto: {{ $dish->pivot->dish_quantity }}</p>
                </div>
            @endforeach
        </div>
    @endforeach

@endsection
