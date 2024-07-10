<!DOCTYPE html>
<html>
<head>
    <title>Riepilogo ordine</title>
</head>
<body>
    <h1>Riepilogo ordine</h1>
    <p><strong>Nome:</strong> {{ $lead['customer_name'] }}</p>
    <p><strong>Cognome:</strong> {{ $lead['customer_lastname'] }}</p>
    <p><strong>Email:</strong> {{ $lead['customer_email'] }}</p>
    <p><strong>Indirizzo:</strong> {{ $lead['customer_adress'] }}</p>
    <p><strong>Telefono:</strong> {{ $lead['customer_phone'] }}</p>
    <p><strong>Data e ora ordine:</strong> {{ $lead['order_date'] }}</p>
    <p><strong>Totale ordine:</strong> {{ $lead['total_price'] }}</p>

    <ul>
        @foreach($orderedDishes as $dish)
        <li> nome piatto {{ $dish['name'] }} - Quantità: {{ $dish['qty'] }} - Prezzo unitazio: {{ $dish['price'] }}</li>
        @endforeach
    </ul>
</body>
</html>