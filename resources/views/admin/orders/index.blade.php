@section('title', 'Ordini: ' . $restaurant->name)
@extends('layouts.admin')

@section('content')
    <h2 class="text-center display-3 fw-bold title-primary my-3 w-100">Ordini del ristorante:
        {{ $restaurant->name }}</h2>
    <div class="accordion container py-5" id="ordersAccordion">
        @foreach ($orders as $order)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $order->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $order->id }}" aria-expanded="true"
                        aria-controls="collapse{{ $order->id }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-4 fs-5">Nome Utente: {{ $order->customer_name }}
                                    {{ $order->customer_lastname }}</div>
                                <div class="col-4 fs-5">Data e Ora:
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y - H:i') }}</div>
                                <div class="col-4 fs-5">Totale: {{ $order->total_price }}€</div>
                            </div>
                        </div>
                        {{-- <table class="table table-bordered">
                            <tr>
                                <th class="col-2 d-none d-xl-table-cell">Nome Utente: {{ $order->customer_name }}</th>
                                <th class="col-2 d-none d-xl-table-cell">Data e Ora:
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y - H:i') }}</th>
                                <th class="col-2 d-none d-xl-table-cell">Totale: {{ $order->total_price }} €</th>
                            </tr>
                        </table> --}}

                    </button>
                </h2>
                <div id="collapse{{ $order->id }}" class="accordion-collapse collapse"
                    aria-labelledby="heading{{ $order->id }}" data-bs-parent="#ordersAccordion">
                    <div class="accordion-body">
                        <h2>Dettagli Cliente</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nome Utente</th>
                                <td>{{ $order->customer_name }} {{ $order->customer_lastname }}</td>
                            </tr>
                            <tr>
                                <th>Numero Telefono</th>
                                <td>{{ $order->customer_phone }}</td>
                            </tr>
                            <tr>
                                <th>Indirizzo</th>
                                <td>{{ $order->customer_address }}</td>
                            </tr>
                            <tr>
                                <th>Data e Ora</th>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y - H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->customer_email }}</td>
                            </tr>
                            <tr>
                                <th>Totale</th>
                                <td>{{ $order->total_price }} €</td>
                            </tr>
                        </table>

                        <h2>Piatti Ordinati</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nome Piatto</th>
                                    <th>Quantità Piatto</th>
                                    <th>Prezzo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->dishes as $dish)
                                    <tr>
                                        <td>{{ $dish->pivot->dish_name }}</td>
                                        <td>{{ $dish->pivot->dish_quantity }}</td>
                                        <td>{{ $dish->pivot->dish_price }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
