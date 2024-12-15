<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{--    <meta charset="utf-8">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        body {
            font-family: DejaVu Sans;
        }

    </style>
</head>
<body>
<h2>Szczegóły zamówienia numer {{ $order->id }}:</h2>
<p>Zamówienie z dnia: {{ $order->created_at }}</p>
<p>Zamawiajacy: {{ $order->name }}</p>
<p>Adres: {{ $order->adress }}</p>
<p>E-mail: {{ $order->email }}</p>
<p>Telefon: {{ $order->phone }}</p>

@if($order->vat == 1)
    <p><b>Dane do faktury VAT:</b></p>
    <p>NIP: {{ $order->vatNumber }}</p>
    <p>Nazwa: {{ $order->vatName }}</p>
    <p>Adres: {{ $order->vatAdress }}</p>
@endif

<table id="orderTable" class="orderTable">
    <thead>
    <tr class="tableHead">
        <th>Nazwa produktu</th>
        <th>Cena</th>
        <th>Ilość</th>
        <th>Wartość</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    @foreach ($order->carts as $art)
        <tr class="tableRow">
            <td>{{ $art['name'] }}</td>
            <td>{{ numberFormat($art['price']) }} zł</td>
            <td style="text-align: center">{{ $art['quantity'] }}</td>
            <td style="text-align: right" class="subtotal">{{ numberFormat($art['price'] * $art['quantity']) }} zł</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: right">Razem:</td>
        <td style="text-align: right" class="basketTotal">{{ numberFormat($totalOrder) }} zł</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: right">{{ $order->shipping->name }}:</td>
        <td style="text-align: right" class="shipping">{{ numberFormat($order->shipping->shipping) }} zł</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: right">Do zapłaty:</td>
        <td style="text-align: right" class="toPay">{{ numberFormat($order->shipping->shipping + $totalOrder) }} zł</td>
    </tr>
    </tfoot>
</table>
</body>
</html>

