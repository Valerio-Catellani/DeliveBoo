@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')

@section('content')


    @if (count($orders) == 0)
        <h1>Non hai ancora ricevuto ordini</h1>
    @elseif (count($orders) > 0)
    @foreach ($orders as $order)
        <div>
            <h1>Numero Ordine: {{ $order->id }}</h1>
            <h2>Nome Utente: {{ $order->customer_name }}</h2>
            <h2>Numero Telefono: {{ $order->customer_phone }}</h2>
            <h2>Indirizzo: {{ $order->customer_address }}</h2>
            <h2>Data e Ora: {{ $order->created_at }}</h2>
            <h2>Email: {{ $order->customer_email }}</h2>
            <h2>Totale: {{ $order->total_price }}</h2>


            @foreach ($order->dishes as $dish)
                <div class="border border-3">
                    <p>Nome Piatto: {{ $dish->pivot->dish_name }}</p>
                    <p>Prezzo Piatto: {{ $dish->pivot->dish_price }}</p>
                    <p>Quantità Piatto: {{ $dish->pivot->dish_quantity }}</p>
                </div>
            @endforeach
        </div>
    @endforeach

    @endif

@endsection
