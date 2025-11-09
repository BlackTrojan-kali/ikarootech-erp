<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture Client Stargas SCMS</title>
</head>

<body>
    <style>
        /* Styles CSS optimisés pour DomPDF */

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
            font-size: 10px;
        }

        .no-break-inside {
            page-break-inside: avoid;
        }

        header {
            text-align: center;
            position: relative;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            height: 150px;
            margin-bottom: 15px;
            overflow: hidden; /* Assure que les flottants sont contenus */
        }

        .logo-section {
            width: 90px; /* Largeur du conteneur du logo et des infos */
            text-align: start;
            float: left;
        }
        .logo-section img {
            width: 90px; /* Taille réelle de l'image du logo */
            height: auto;
        }

        .company-info {
            font-size: 0.9em;
            color: black;
            text-align: start;
            line-height: 1.3;
            margin-top: 5px; /* Petite marge au-dessus des infos */
        }

        .name-section {
            text-align: center;
            font-weight: bold;
            float: right;
            width: calc(100% - 160px); /* Laisse de l'espace pour le logo-section + marge */
            margin-top: 10px;
        }
        .name-section h4 {
            margin: 0;
            font-size: 1.3em;
        }
        .name-section p {
            margin: 0;
            font-size: 1.1em;
        }

        .head-info-section {
            clear: both;
            position: relative;
            margin-top: 15px;
            overflow: hidden;
        }

        .customer-section {
            text-align: start;
            width: 55%;
            float: left;
            margin-bottom: 10px;
        }

        .invoice-details-section {
            text-align: start;
            width: 40%;
            float: right;
        }
        .customer-section p, .invoice-details-section p {
            margin: 0 0 3px 0;
        }

        .table-container {
            clear: both;
            width: 100%;
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .table-container table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 0.9em;
        }

        .table-container td, .table-container th {
            padding: 5px;
            border: 1px solid black;
            text-align: left;
        }

        .table-container table thead {
            background-color: rgb(138, 218, 250);
            width: 100%;
        }
        .table-container table thead td {
            font-weight: bold;
        }

        .total-summary {
            background-color: rgb(106, 171, 197);
            width: 280px;
            color: white;
            float: right;
            padding: 10px;
            margin-top: 10px;
            text-align: right;
            clear: right;
        }
        .total-summary p {
            margin: 2px 0;
            font-size: 1.1em;
        }

        .english-translation {
            font-size: 0.8em;
            display: block;
        }

        .signature-section {
            clear: both;
            position: relative;
            margin-top: 60px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 48%;
            min-height: 80px;
        }
        .signature-client {
            float: left;
            text-align: left;
        }
        .signature-salesman {
            float: right;
            text-align: right;
        }

        .bank-details-section {
            clear: both;
            border-top: 2px dashed black;
            margin-top: 20px;
            padding-top: 10px;
            page-break-inside: avoid;
        }

        .bank-details-section h4 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 1.1em;
        }

        .bank-details-section table {
            text-align: center;
            width: 100%;
            background-color: rgb(218, 218, 255);
            border-collapse: collapse;
            font-size: 0.75em;
            margin-top: 10px;
        }
        .bank-details-section table th, .bank-details-section table td {
            padding: 3px;
            border: 1px solid black;
        }
        .bank-details-section table thead td {
            font-weight: bold;
            background-color: rgb(190, 190, 250);
        }

        .contribution-info {
            font-size: 0.8em;
            text-align: center;
            margin-top: 10px;
            line-height: 1.4;
        }

        sup {
            font-size: 0.7em;
        }
    </style>
    <header>
        <div class="logo-section">
            {{-- Utilisation de l'intégration Base64 pour le logo : la méthode la plus fiable --}}
            <img src="images/logo.png"
                alt="Logo Stargas">
            <p class="company-info">
                <b>{{ env('COMPANIE_NAME') }}</b><br>
                <b>B.P:</b> {{ env('COMPANIE_ADDRESS') }} <br>
                <b>Tél:</b> {{ env('COMPANIE_CANTACT_1') }} <br>
                <b>Email:</b> {{ env('COMPANIE_EMAIL_1') }} <br>
            </p>
        </div>
        <div class="name-section">
            <h4>FACTURE CLIENT</h4>
            <h4>CUSTOMER INVOICE</h4>
            <p>N <sup>O</sup>: {{ $invoice->id }}{{ strtoupper(substr($invoice->region, 0, 2)) }}</p>
        </div>
    </header>

    <div class="head-info-section no-break-inside">
        <div class="customer-section">
            <p>
                Nom du Client: <b>{{ $client->nom . ' ' . $client->prenom }}</b><br>
                <span class="english-translation">Customer Name</span><br>
                Adresse: <b>{{ $client->address }}</b> <br>
                <span class="english-translation">Address</span><br>
                Numéro de téléphone: <b>{{ $client->numero }}</b> <br>
                <span class="english-translation">Phone Number</span><br>
                Agent Commercial: <b>{{ $invoice->commercial }} - {{ $invoice->region }}</b> <br>
                <span class="english-translation">Sales Representative</span>
            </p>
        </div>
        <div class="invoice-details-section">
            <p>
                Date Facturation : <b>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i') }}</b><br>
                <span class="english-translation">Invoice Date</span><br>
                Référence Commande: <b>{{ $invoice->order_reference ?? 'N/A' }}</b><br>
                <span class="english-translation">Order Reference</span><br>
                Mode de Paiement : <b> {{ $invoice->currency }}</b> <br>
                <span class="english-translation">Payment Mode</span>
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="table-container no-break-inside">
        <table>
            <thead>
                <tr>
                    <td>Désignation <br><span class="english-translation">Item</span></td>
                    <td>Quantité <br> <span class="english-translation">Quantity</span></td>
                    <td>PU(XAF) <br><span class="english-translation">Unit Price</span></td>
                    <td>PT <span class="english-translation">HT</span>(XAF)</td>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($invoice->articles, true) as $article)
                    <tr>
                        <td>
                            @if ($article['name'] == 'stargas')
                                Bouteille-gaz
                                @if (isset($article['weight']) && $article['weight'] > 0)
                                    {{ $article['weight'] }} KG
                                @endif
                                @else
                                {{ $article['name'] }}
                            @endif
                        </td>
                        <td>{{ $article['qty'] }}</td>
                        <td>{{ number_format($article['price'], 2, ",", " ") }}</td>
                        <td>{{ number_format($article['subtotal'], 2, ',', ' ') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total-summary">
            <p>Montant Total HT:
                {{ number_format($invoice->total_price, 2, ',', ' ') }} XAF
            </p>
            <p>Montant Total TTC :
                {{ number_format($invoice->total_price, 2, ',', ' ') }} XAF
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="signature-section no-break-inside">
        <div class="signature-box signature-client">
            Client(s) <br>
            <span class="english-translation">Customer</span>
        </div>
        <div class="signature-box signature-salesman">
            Vendeur(s) <br>
            <span class="english-translation">Salesman</span>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="bank-details-section no-break-inside">
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
                        <td>Numéro de compte</td>
                        <td>Clé RIB</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ env('COMPANIE_BANK_2') }} Bank</td>
                        <td>{{ env('COMPANIE_NAME') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_bank_code') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_guichet') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_ACCOUNT') }}</td>
                        <td>{{ env('COMPANIE_BANK_2_RIB') }}</td>
                    </tr>
                    <tr>
                        <td>{{ env('COMPANIE_BANK_1') }} Bank</td>
                        <td>{{ env('COMPANIE_NAME') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_bank_code') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_guichet') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_ACCOUNT') }}</td>
                        <td>{{ env('COMPANIE_BANK_1_RIB') }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="contribution-info">
                <i>
                    <b>Siège: {{ env('COMPANIE_LOCATION') }} Adresse: 6792 Yaoundé Tél:+237
                        {{ env('COMPANIE_CANTACT_1') }}/
                        {{ env('COMPANIE_CANTACT_2') }}
                        Mail: <br>
                        {{ env('COMPANIE_EMAIL_1') }}/{{ env('COMPANIE_EMAIL_2') }} Num contribuable:
                        {{ env('COMPANIE_CONTRIB') }} Reg
                        Commerce: {{ env('COMPANIE_COMMERCE') }} <br>
                        Site Web : {{ env('COMPANIE_SITE') }}
                    </b>
                </i>
            </p>
        </center>
    </div>

</body>

</html>