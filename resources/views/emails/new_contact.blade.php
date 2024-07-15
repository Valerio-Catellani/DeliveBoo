<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Riepilogo ordine</title>
</head>

<body>

    <div>
        <h1 class="py-3">Riepilogo ordine</h1>
        <h2>Dettagli cliente</h2>
        <table class="table table-bordered">
            <tr>
                <th>Nome utente</th>
                <td>{{ $lead['customer_name'] }} {{ $lead['customer_lastname'] }}</td>
            </tr>
            <tr>
                <th>Numero di telefono</th>
                <td>{{ $lead['customer_phone'] }}</td>
            </tr>
            <tr>
                <th>Indirizzo</th>
                <td>{{ $lead['customer_adress'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $lead['customer_email'] }}</td>
            </tr>
            <tr>
                <th>Data e ora pagamento</th>
                <td>{{ \Carbon\Carbon::parse($lead['order_date'])->format('d/m/Y H:i') }}</td>
            </tr>

            <tr>
                <th>Totale ordine:</th>
                <td>{{ $lead['total_price'] }} €</td>
            </tr>
        </table>

        <h2>Piatti ordinati</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome </th>
                    <th>Prezzo </th>
                    <th>Quantità </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderedDishes as $dish)
                    <tr>
                        <td>{{ $dish['name'] }}</td>
                        <td>{{ $dish['price'] }}€</td>
                        <td>{{ $dish['qty'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</body>

</html>
