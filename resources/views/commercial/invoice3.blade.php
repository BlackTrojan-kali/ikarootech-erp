<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stargas SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="mx-20">
    <style>
        @font-face {
            font-family: 'Riot';
            src: url({{ storage_path('/fonts/ProtestRiot-Regular.ttf') }});
            font-weight: 400;
            font-style: normal;
        }

        body {
            font-family: "Riot";
            margin: 5px;
        }

        header {
            text-align: center;
            position: relative;
            border-bottom: 3px solid black;
        }

        .logo-section {
            width: 130px;
            text-align: start;
        }

        .name-section {
            position: absolute;
            top: 0;
            left: 45%;
            text-align: center;
            font-weight: bold;
        }

        .head-2 {
            position: relative;
        }

        .customer-section {
            text-align: start;
            margin-bottom: 10px
        }

        .stargas-section {
            text-align: start;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .table {
            position: relative;
            widows: 100%;

        }

        .table table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }

        .table td {
            padding: 10px;
        }

        td {

            border: 1px solid black;
        }

        .table table thead {
            background-color: rgb(138, 218, 250);

            width: 100%;
            padding: 10px;
        }

        .my-total {
            background-color: rgb(106, 171, 197);
            width: 300px;
            color: white;
            position: absolute;
            right: 0;
            padding: 10px;
        }

        .english {
            font-size: 0.8rem;
        }

        .signature {
            position: relative;
        }

        .client {
            height: 100px;
        }

        .salesMan {
            position: absolute;
            right: 10px;
            top: 0;
        }

        .comptes {
            border-top: 2px dashed black;
        }

        .comptes table {
            text-align: center;
            width: 100%;
            background-color: rgb(218, 218, 255);
            border-collapse: collapse;
            font-size: 0.8rem
        }

        .contri {
            font-size: 0.9rem
        }

        sup {
            font-size: 0.8rem;
        }
    </style>
    <header>
        <div class="logo-section">
            <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo.png'))) }}"
                width="150px">
            <p>
                <b>{{ env('COMPANIE_NAME') }}</b><br>
                <b>B.P:</b>{{ env('COMPANIE_ADDRESS') }} <br>
                <b>Tél:</b>{{ env('COMPANIE_CANTACT_1') }} <br>
                <b>Email:</b> {{ env('COMPANIE_EMAIL_1') }} <br>
            </p>

        </div>
        <div class="name-section">
            <h4>FACTURE CLIENT</h4>
            <h4>CUSTOMER INVOICE</h4>


            <p>N <sup>O</sup>:{{ $invoice->id }}{{ strtoupper(substr($invoice->region, 0, 2)) }}</p>
        </div>

    </header>

    <div class="head-2">

        <div class="customer-section">
            <p>
                nom du Client: <b> {{ $client->nom . ' ' . $client->prenom }}</b><br>
                <span class="english"> customer </span>: <b>{{ $client->nom . ' ' . $client->prenom }}</b><br>
                Adresse: <b>{{ $client->address }}</b> <br>
                <span class="english">address</span> <br>
                Numero: {{ $client->numero }} <br>
                Agent Commercial: <b>{{ $invoice->commercial }} - {{ $invoice->region }}</b> <br>
                <span class="english"> Sales Representative:</span>
            </p>
        </div>
        <div class="stargas-section">
            <p>
                Date Facturation : <b>{{ $invoice->created_at }}</b><br>
                <span class="english"> Date invoice : <br></span>
                Commande Reference: <br>
                <span class="english"> Order Reference: <br></span>
                Mode de Paiement : <b> {{ $invoice->currency }}</b> <br>
                <span class="english"> payment Mode: <br></span>
            </p>
        </div>
    </div>
    <br>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Designation <br><span class="english"> Item</span></td>
                    <td>Quantite <br> <span class="english">Quantity</span></td>
                    <td>PU(XAF) <br><span class="english">Unit Price</span></td>
                    <td>PT <span class="english">HT</span>(XAF)</td>
                </tr>
            </thead>
            <?php
            $articles = json_decode($invoice->articles, true);
            ?>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article['id'] }}</td>
                        <td>{{ $article['name'] == 'stargas' ? 'bouteille-gas' . $article['weight'] . ' KG' : $article['name'] }}
                        </td>
                        <td>{{ $article['qty'] }}</td>
                        <td>{{ $article['price'] }}</td>
                        <td>{{ $article['subtotal'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-total">
            <p>Montant Total HT:
                {{ number_format($invoice->total_price, 2, ',', ' ') }}
            </p>

            <p>Montant Total TTC :
                {{ number_format($invoice->total_price, 2, ',', ' ') }}
            </p>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br><br>
    <div class="signature">
        <div class="client">
            Client(s) <br>
            <span class="english">customer</span>
        </div>
        <div class="salesMan">
            Vendeurs(s)
            <span class="english">SalesMan</span>
        </div>
    </div>
    <div class="comptes">
        <center>
            <h4>STARGAS S.A</h4>
            <table>
                <thead>
                    <tr>
                        <td colspan="6">Nos Comptes bancaires</td>
                    </tr>
                    <tr>
                        <td>Banque</td>
                        <td>Titulaire du compte</td>
                        <td>Code banque</td>
                        <td>Code guichet</td>
                        <td>Numero de compte</td>
                        <td>cle RIB</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ env('COMPANIE_BANK_2') }} bank</td>
                        <td>{{ env('COMPANIE_NAME') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_bank_code') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_guichet') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_ACCOUNT') }}</td>
                        <td>
                            {{ env('COMPANIE_BANK_2_RIB') }}
                        </td>
                    </tr>
                    <tr>

                        <td>{{ env('COMPANIE_BANK_1') }} bank</td>
                        <td>{{ env('COMPANIE_NAME') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_bank_code') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_guichet') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_ACCOUNT') }}</td>
                        <td>
                            {{ env('COMPANIE_BANK_1_RIB') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="contri"><i><b>Siège: {{ env('COMPANIE_LOCATION') }}Adresse:6792 Yaoundé Tél:+237
                        {{ env('COMPANIE_CONTACT_1') }}/
                        {{ env('COMPANIE_CANTACT_2') }}
                        08 Mail: <br>
                        {{ env('COMPANIE_EMAIL_2') }}/{{ env('COMPANIE_EMAIL_2') }} Num contribuable:
                        {{ env('COMPANIE_CONTRIB') }} Reg
                        Commerce: {{ env('COMPANIE_COMMERCE') }} <br>
                        Site Web : {{ env('COMPANIE_SITE') }}
                    </b></i></p>
    </div>

</body>
