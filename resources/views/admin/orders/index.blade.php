@section('title', 'Dettagli Ristorante')
@extends('layouts.admin')

@section('content')
    <div class="accordion" id="ordersAccordion">
        @foreach ($orders as $order)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $order->id }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="true" aria-controls="collapse{{ $order->id }}">
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-2 d-none d-xl-table-cell">Nome Utente:  {{  $order->customer_name }}</th>
                                <th class="col-2 d-none d-xl-table-cell">Data e Ora:  {{  \Carbon\Carbon::parse($order->created_at)->format('d/m/Y - H:i') }}</th>
                                <th class="col-2 d-none d-xl-table-cell">Totale:  € {{  $order->total_price }}</th>
                            </tr>
                        </table>

                    </button>
                </h2>
                <div id="collapse{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id }}" data-bs-parent="#ordersAccordion">
                    <div class="accordion-body">
                        <h2>Dettagli Cliente</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nome Utente</th>
                                <td>{{ $order->customer_name }}</td>
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
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y - H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->customer_email }}</td>
                            </tr>
                            <tr>
                                <th>Totale</th>
                                <td>{{ $order->total_price }}</td>
                            </tr>
                        </table>
                        
                        <h2>Piatti Ordinati</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nome Piatto</th>
                                    <th>Prezzo Piatto</th>
                                    <th>Quantità Piatto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->dishes as $dish)
                                    <tr>
                                        <td>{{ $dish->pivot->dish_name }}</td>
                                        <td>{{ $dish->pivot->dish_price }}</td>
                                        <td>{{ $dish->pivot->dish_quantity }}</td>
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