<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umowa Wynajmu Fotobudki 360</title>
    <link rel="stylesheet" href="{{ asset('/css/contracts/photo_booth_contract.css') }}">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            text-align: center;
            margin-top: 15px;
            color: #666;
        }

        p {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            text-align: left;
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .parties th {
            text-align: center;
            font-weight: normal;
        }

        .signatures {
            margin-top: 110px;
            width: 100%;
        }

        .signature-box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }

        .signature-box p {
            margin: 5px 0;
        }

        .signature-landlord {
            text-align: left;
        }

        .signature-contractor {
            text-align: right;
        }

        .information-title {
            margin-top: 20px;
        }

        .info-list {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .info-list li {
            margin-bottom: 10px;
        }

        .consent {
            width: 100%;
            margin-top: 40px;
        }

        .consent-box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }

        .consent-label {
            display: block;
            margin: 0 0 10px;
            padding: 10px;
        }

        .links {
            margin-top: 20px;
            text-align: center;
        }

        .links a {
            margin: 0 10px;
            text-decoration: none;
            color: #007bff;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    @php
        use Carbon\Carbon;
    @endphp

    <h1>UMOWA WYNAJMU FOTOBUDKI 360</h1>

    <p>Zawarta w dniu: {{ Carbon::now()->format('d-m-Y') }}<br>
        pomiędzy:</p>

    <p>{{config('photobooth.owner.name')}}, ul.{{config('photobooth.owner.address')}},<br>
        (Zwanym dalej Wykonawcą)</p>

    <p>a:</p>

    <table>
        <tr>
            <td>Imię i nazwisko:</td>
            <td>{{ $event->client->getFullName() }}</td>
        </tr>
        <tr>
            <td>Adres zamieszkania:</td>
            <td>{{ $event->clientAddress->getFullAddress() }}</td>
        </tr>
        <tr>
            <td>PESEL:</td>
            <td>{{ $event->client->pesel }}</td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td>{{ $event->client->phone }}</td>
        </tr>
    </table>

    <p>(Zwanym dalej Wynajmującym).</p>

    <h2>§1</h2>
    <p>Niniejsza umowa stanowi potwierdzenie warunków zawartych pomiędzy stronami na odległość.</p>

    <h2>§2</h2>
    <p>Przedmiotem umowy jest usługa związana z wynajmem Fotobudki 360 oraz doprecyzowanie niektórych kwestii
        szczegółowych.</p>

    <h2>§3</h2>
    <p>Wykonawca zobowiązuje się dostarczyć Fotobudkę 360 pod wskazany niżej adres w ustalonym terminie.</p>
    <table>
        <tr>
            <td>Termin uroczystości:</td>
            <td>{{ Carbon::parse($event->start_time)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Adres dostarczenia Fotobudki:</td>
            <td>{{$event->deliveryAddress->getFullAddress()}}</td>
        </tr>
        <tr>
            <td>Godzina rozpoczęcia:</td>
            <td>{{ Carbon::parse($event->start_time)->format('H:i') }}</td>
        </tr>
        <tr>
            <td>Godzina zakończenia:</td>
            <td>{{ Carbon::parse($event->end_time)->format('H:i') }}</td>
        </tr>
        <tr>
            <td>Czas wynajmu:</td>
            <td>{{ $event->cost->package->rental_time}} minut</td>
        </tr>
        <tr>
            <td>Kontakt do lokalu:</td>
            <td></td>
        </tr>
    </table>

    <h2>§4</h2>
    <p>Najemca zobowiązuje się do zapłaty na rzecz wykonawcy wynagrodzenia w wysokości zgodnej z niżej wyliczoną
        sumą.</p>
    <table>
        <tr>
            <td>Cena za najem (pakiet):</td>
            <td>{{ $event->cost->package->price + $event->cost->discount }} zł</td>
        </tr>
        <tr>
            <td>Koszt transportu (wyliczony zgodnie z cennikiem):</td>
            <td>{{ $event->cost->transport_price }} zł</td>
        </tr>
        <tr>
            <td>Cena za dodatki:</td>
            <td>{{ $event->cost->addons_price }} zł</td>
        </tr>
        <tr>
            <td>Razem do zapłaty:</td>
            <td>{{ $event->cost->total_cost }} zł</td>
        </tr>
    </table>


    <h2>§5</h2>
    <p>Rezerwację uważa się za dokonaną po wpłacie przez Najemcę zaliczki w gotówce lub na konto Bank
        Millennium {{config('photobooth.owner.bank_account')}} w wysokości 30% całości kwoty należności wynikającej z
        Umowy Wynajmu. Zadatek należy
        wpłacić w terminie 3 dni od daty przyjęcia wstępnej rezerwacji. Wpłata zaliczki jest gwarancją rezerwacji
        terminu. Brak wpłaty jest podstawą do anulowania Umowy Wynajmu. Pozostałą część zapłaty za usługę Najemca
        zobowiązuje się uiścić w gotówce najpóźniej w ciągu 7 dni od wykonania usługi.</p>

    <h2>§6</h2>
    <p>Na wskutek wystąpienia zdarzeń losowych, wynajmujący może odstąpić od wynajmu Fotobudki 360.</p>

    <h2>§7</h2>
    <p>W przypadku wystąpienia zdarzeń losowych uniemożliwiających wykonawcy dostarczenie Fotobudki 360 na wskazane
        miejsce lub wykonanie usługi, wykonawca nie ponosi odpowiedzialności za ewentualne szkody wynikłe z takiej
        sytuacji. W takim przypadku wykonawca zobowiązuje się do jak najszybszego poinformowania najemcy o zaistniałej
        sytuacji oraz do podjęcia działań w celu znalezienia alternatywnego rozwiązania lub ustalenia nowego terminu
        usługi.</p>

    <h2>§8</h2>
    <p>Wszelkie zmiany niniejszej umowy wymagają zgodnego oświadczenia woli obu stron w formie pisemnej pod rygorem
        nieważności.</p>

    <h2>§9</h2>
    <p>Najemca oraz jego goście zobowiązują się korzystać z Fotobudki 360 zgodnie z jej przeznaczeniem, dbając o jej
        stan techniczny i unikając wszelkich działań, które mogą prowadzić do jej uszkodzenia lub niewłaściwego
        funkcjonowania. Wynajmujący, jako obsługa Fotobudki 360, zobowiązuje się do zapewnienia właściwego
        funkcjonowania urządzenia oraz do nadzorowania użytkowania przez Najemcę i jego gości w celu zapobieżenia
        wszelkim szkodom i uszkodzeniom.</p>

    <h2>§10</h2>
    <p>Wynajmujący oświadcza, iż zapoznał się z informacjami zawartymi na końcu niniejszej umowy.</p>

    <h2>§11</h2>
    <p>W sprawach nieuregulowanych niniejszą umową mają zastosowanie przepisy Kodeksu Cywilnego.</p>

    <div class="signatures">
        <div class="signature-box signature-landlord">
            <p>WYNAJMUJĄCY:</p>
            <p>………………………</p>
            <p>(czytelny podpis)</p>
        </div>
        <div class="signature-box signature-contractor">
            <p>WYKONAWCA:</p>
            <p>……………………….</p>
            <p>(czytelny podpis)</p>
        </div>
    </div>

    <h2 class="information-title">INFORMACJE</h2>
    <ul class="info-list">
        <li>Obsługa z Fotobudką 360 dojeżdża na miejsce odpowiednio wcześnie.<br>Potrzebujemy około 1 godziny na montaż
            całego sprzętu oraz tyle samo na jego złożenie.
        </li>
        <li>Miejsce - sama Fotobudka 360 zajmuje ok. 2m x 2m (2 metry wysokości).<br>Jednak wskazana powierzchnia to 4
            metry szerokości na 4 metry głębokości.
        </li>
        <li>Prąd - potrzebujemy zwykłe zasilanie 230V. Zalecana odległość max 5 metrów.</li>
        <li>Warunki oświetlenia - miejsce ustawienia urządzenia nie może znajdować się bezpośrednio w naświetleniu
            słonecznym oraz przed reflektorami.
        </li>
        <li>Gwarantujemy pełną obsługę (montaż, demontaż Fotobudki 360, opiekę nad gośćmi).</li>
        <li>Filmy wykonane przy użyciu Fotobudki 360 będą dostępne do pobrania bezpośrednio na miejscu podczas trwania
            imprezy. Dodatkowo, te same filmy będą również dostępne w chmurze przez okres dwóch tygodni od daty
            zakończenia wydarzenia.
        </li>
        <li>Wykonawca nie ponosi odpowiedzialności za ewentualne problemy związane z działaniem aplikacji do Fotobudki
            360 stopni, w tym za błędy, przerwy w dostępie lub inne zakłócenia w działaniu aplikacji.
        </li>
        <li>Dodatkowo, należy pamiętać, że działanie aplikacji do Fotobudki 360 stopni może być uzależnione od
            stabilnego połączenia internetowego. W naszym przypadku korzystamy z własnego połączenia internetowego
            mobilnego. Jednakże, jeśli wystąpią problemy związane z słabym zasięgiem lub innymi czynnikami,
            rekomendujemy zapewnienie dostępu do sieci Wi-Fi w lokalu, aby zapewnić ciągłość działania aplikacji.
        </li>
        <li>Wynajmujący wyraża zgodę na późniejsze wykorzystanie filmów w materiałach reklamowych działalności
            wykonawcy, na przykład umieszczanie filmów na stronie internetowej oraz w mediach społecznościowych i z tego
            tytułu nie będzie przedstawiał żadnych roszczeń.
        </li>
    </ul>

    <div class="consent">
        <div class="consent-box">
            <label class="consent-label">TAK WYRAŻAM ZGODĘ</label>
        </div>
        <div class="consent-box">
            <label class="consent-label">NIE WYRAŻAM ZGODY</label>
        </div>
    </div>

    <div class="links">
        @if($showLinks)
            <a href="{{ route('contracts.preview', ['eventId' => $event->id]) }}"
               target="_blank">{{__('translations.preview')}}</a>
        @endif
    </div>
</div>

</body>
</html>
