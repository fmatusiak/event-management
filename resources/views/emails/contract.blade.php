<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umowa na wynajem Fotobudki 360</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
@if (isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif

<p>Szanowny/a {{ $event->client->first_name }} {{ $event->client->last_name }},</p>

<p>
    Dziękujemy za wybór naszej fotobudki 360. W załączniku znajdziesz umowę wynajmu, która zawiera wszystkie szczegóły dotyczące Twojej rezerwacji.
</p>
<br>
<p>
    <strong>Szczegóły rezerwacji:</strong><br>
</p>
<table>
    <tr>
        <td><strong>Data rozpoczęcia wynajmu:</strong></td>
        <td>{{ Carbon\Carbon::parse($event->start_time)->format('d-m-Y H:i') }}</td>
    </tr>
    <tr>
        <td><strong>Data zakończenia wynajmu:</strong></td>
        <td>{{ Carbon\Carbon::parse($event->end_time)->format('d-m-Y H:i') }}</td>
    </tr>
    <tr>
        <td><strong>Czas trwania wynajmu:</strong></td>
        <td>{{ $event->cost->package->rental_time }} minut</td>
    </tr>
    <tr>
        <td><strong>Adres dostarczenia:</strong></td>
        <td>{{ $event->deliveryAddress->street }}, {{ $event->deliveryAddress->postcode }} {{ $event->deliveryAddress->city }}</td>
    </tr>
    <tr>
        <td><strong>Cena:</strong></td>
        <td>{{ $event->cost->total_cost }} zł</td>
    </tr>
    <tr>
        <td><strong>Zadatek:</strong></td>
        <td>{{ $event->cost->deposit_cost }} zł</td>
    </tr>
    <tr>
        <td><strong>Reszta do zapłaty:</strong></td>
        <td>{{ $event->cost->remaining_cost }} zł</td>
    </tr>
</table>

<p>Zadatek należy wpłacić w terminie 3 dni od daty przyjęcia wstępnej rezerwacji. Wpłata zaliczki jest gwarancją rezerwacji terminu.</p>
<p>
    Prosimy o dokładne zapoznanie się z umową i jej podpisanie. Jeśli masz jakiekolwiek pytania, prosimy o kontakt.
</p>

<p>
    Z poważaniem,<br>
    {{config('photobooth.owner.name')}}
</p>

</body>
</html>
