@section('title', 'Dettagli Ristorante: ')
@extends('layouts.admin')

@section('content')

<ul>
    @foreach ($bills as $bill)
    <li>
        @foreach ($arrayPiatti as $piatti)
        @dump($piatti->name)
        @endforeach
        <!-- @dd($bill->dishes) -->
        @foreach ($bill->dishes as $dish)
        @dd($dish->name)

        @endforeach
    </li>
    <li>
        {{$bill->customer_name}}
    </li>
    @endforeach
</ul>
@endsection