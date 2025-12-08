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

<body class="">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @font-face {
            font-family: 'Riot';
            src: url({{ storage_path('/fonts/ProtestRiot-Regular.ttf') }}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        body {
            font-family: "Riot";
            padding: 5px;
        }

        table {
            border: 1px solid white;
            border-collapse: collapse;
        }

        .table-1,
        .table-2,
        .table-3 {
            border: 2px solid black;

        }

        .table-1 th,
        .table-2 th,
        .table-3 th {
            font-size: 0.8rem;

        }

        .table-1 th,
        .table-1 tr,
        .table-1 td,
        .table-2 th,
        .table-2 tr,
        .table-2 td,
        .table-3 th,
        .table-3 tr,
        .table-3 td {
            border: 1px solid black;
            padding: 4px;

        }

        .logo-section {
            position: absolute;
            top: 2px;
        }

        .head-color {
            background-color: burlywood;
            padding: 20px;
        }
    </style>
    <br>
    <br><br>
    <br>
    <br><br><br>
    <br><br>

    <div class="logo-section">
        <img src="{{public_path('images/logo.png')}}"
            width="100px">
        <p>
            <b>{{ env('COMPANIE_NAME') }}</b><br>
            <b>B.P:</b>{{ env('COMPANIE_ADDRESS') }} <br>
            <b>Tél:</b>{{ env('COMPANIE_CANTACT_1') }} <br>
            <b>Email:</b> {{ env('COMPANIE_EMAIL_1') }} <br>
        </p>
    </div>
    <center>
        <h3>{{ strtoupper(Auth::user()->role) }} :{{ strtoupper(Auth::user()->region) }} </h3 <h4> FICHE DE VERSEMENTS
                GLOBAL</h4>

    </center>
    <center><u>
            <h1>AFB BANK</h1>
        </u></center>
    <table class="table-1">
        <thead>
            <th colspan="3">VENTES Associees</th>
            <th colspan="7">VERSEMENTS AFB</th>
            <tr>
                <th><b>DATES</b></th>
                <th><b>Factures Associées</b></th>
                <th><b>Total Factures</b></th>
                <th><b>GPL</b></th>
                <th><b>Consigne</b></th>
                <th><b>Total</b></th>
                <th><b>Bordereau</b></th>
                <th><b>Commentaire</b></th>
                <th><b>Total Commentaire</b></th>
                <th><b>Écart</b></th>
            </tr>
        </thead>

        <?php $total1 = 0;
        $total_gpl1 = 0;
        $total_consigne1 = 0;
        $total_com1 = 0;
        
        $total_ecart1 = 0;
        $total_invoices1 = 0;
        ?>

        <tbody>
            @foreach ($afb as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>
                        {{ $data->created_at }}
                    </td>

                    {{-- Colonnes VENTES Associées (Gauche) --}}
                    <td>
                        <ul>
                            <?php $total_factures= 0?>
                            @foreach ($data->Invoice as $facture)
                                <li>Facture N°: {{ $facture->region."-".$facture->id."/".$facture->client->nom." ".$facture->client->prenom}} ({{ $facture->total_price }})</li>
                                <?php $total_factures += $facture->total_price;?>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $total_factures }}</td>
                    
                    {{-- Colonnes VERSEMENTS AFB (Droite) --}}
                    <td>
                        {{ $data->montant_gpl }}
                    </td>
                    <td>{{ $data->montant_consigne }}</td>

                    <?php
                    $versement_total = $data->montant_gpl + $data->montant_consigne;
                    $total1 += $versement_total;
                    $total_gpl1 += $data->montant_gpl;
                    $total_consigne1 += $data->montant_consigne;
                    $total_com1 += $data->montantcom;
                    
                    // NOUVEAU CALCUL DE L'ÉCART
                    $ecart = $total_factures - $versement_total - $data->montantcom; // MODIFIÉ SELON VOTRE DEMANDE
                    
                    $total_ecart1 += $ecart;
                    $total_invoices1 +=$total_factures;
                    ?>
                    
                    <td>{{ $versement_total }}</td>
                    <td>{{$data->bordereau}}</td>
                    <td>{{ $data->commentaire }}</td>
                    <td>{{$data->montantcom}}</td>
                    <td style="{{ $ecart < 0 ? 'color: red;' : 'color: green;' }}">
                        {{ $ecart }}
                    </td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td>/</td>
                <td>/</td>
                <td>{{ number_format($total_invoices1, 2, ',', ' ') }}</td>
                <td>{{ $total_gpl1 }}</td>
                <td>{{ $total_consigne1 }}</td>
                <td>{{ number_format($total1, 2, ',', ' ') }}</td>
                <td>/</td>
                <td>/</td>
                <td>{{ number_format($total_com1, 2, ',', ' ') }}</td>
                <td>{{ number_format($total_ecart1, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>
    
    <br>
    
    <center>
        <u>
            <h1>CCA BANK</h1>
        </u>
    </center>

    <table class="table-2">
        <thead>
            <th colspan="3">VENTES Associees</th>
            <th colspan="7">VERSEMENTS CCA</th>
            <tr>
                <th><b>DATES</b></th>
                <th><b>Factures Associées</b></th>
                <th><b>Total Factures</b></th>
                <th><b>GPL</b></th>
                <th><b>Consigne</b></th>
                <th><b>Total</b></th>
                <th><b>Bordereau</b></th>
                <th><b>Commentaire</b></th>
                <th><b>Total Commentaire</b></th>
                <th><b>Écart</b></th>
            </tr>
        </thead>
        <?php $total2 = 0; // Renommé pour éviter de mélanger avec $total1
        $total_gpl2 = 0; // Renommé
        $total_consigne2 = 0; // Renommé
        $total_com2 = 0;

        $total_ecart2 = 0;
        $total_invoices2 = 0;
          ?>
        
        <tbody>
            @foreach ($cca as $data)
                <tr class="hover:bg-blue-400 border-1 hover:text-white hover:cursor-pointer">
                    <td>
                        {{ $data->created_at }}
                    </td>
                    
                    {{-- Colonnes VENTES Associées (Gauche) --}}
                    <td>
                        <ul>
                            <?php $total_factures= 0?>
                            @foreach ($data->Invoice as $facture)
                            <li>Facture N°: {{ $facture->region."-".$facture->id."/".$facture->client->nom." ".$facture->client->prenom}} ({{ $facture->total_price }})</li>
                            <?php $total_factures += $facture->total_price;?>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $total_factures }}</td>

                    {{-- Colonnes VERSEMENTS CCA (Droite) --}}
                    <td>
                        {{ $data->montant_gpl }}
                    </td>
                    <td>{{ $data->montant_consigne }}</td>
                    
                    <?php
                    $versement_total = $data->montant_gpl + $data->montant_consigne;
                    $total2 += $versement_total;
                    $total_gpl2 += $data->montant_gpl;
                    $total_consigne2 += $data->montant_consigne;
                    $total_com2 += $data->montantcom;
                    
                    // NOUVEAU CALCUL DE L'ÉCART
                    $ecart = $total_factures - $versement_total - $data->montantcom; // MODIFIÉ SELON VOTRE DEMANDE
                    
                    $total_ecart2 += $ecart;
                    $total_invoices2 +=$total_factures;
                    ?>
                    
                    <td>{{ $versement_total }}</td>
                    <td>{{ $data->bordereau }}</td>
                    <td>{{ $data->commentaire }}</td>
                    <td>{{$data->montantcom}}</td>
                    <td style="{{ $ecart < 0 ? 'color: red;' : 'color: green;' }}">
                        {{ $ecart }}
                    </td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td>/</td>
                <td>/</td>
                <td>{{ number_format($total_invoices2, 2, ',', ' ') }}</td>
                <td>{{ $total_gpl2 }}</td>
                <td>{{ $total_consigne2 }}</td>
                <td>{{ number_format($total2, 2, ',', ' ') }}</td>
                <td>/</td>
                <td>/</td>
                <td>{{ number_format($total_com2, 2, ',', ' ') }}</td>
                <td>{{ number_format($total_ecart2, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <center>
        <u>
            <h1>CAISSE</h1>
        </u>
    </center>
    <table class="table-3">
        <thead>
            <th colspan="3">VENTES Associees</th>
            <th colspan="7">VERSEMENTS CAISSE</th>
            <tr>
                <th><b>DATES</b></th>
                <th><b>Factures Associées</b></th>
                <th><b>Total Factures</b></th>
                <th><b>GPL</b></th>
                <th><b>Consigne</b></th>
                <th><b>Total</b></th>
                <th><b>Bordereau</b></th>
                <th><b>Commentaire</b></th>
                <th><b>Total Commentaire</b></th>
                <th><b>Écart</b></th>
            </tr>
        </thead>
        <?php $total3 = 0; // Renommé
        $total_gpl3 = 0; // Renommé
        $total_consigne3 = 0; // Renommé
        $total_com3 = 0;
        
        $total_ecart3 = 0;
        $total_invoices3 = 0;
          ?>
        <tbody>
            @foreach ($caisse as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>
                        {{ $data->created_at }}
                    </td>

                    {{-- Colonnes VENTES Associées (Gauche) --}}
                    <td>
                        <ul>
                            <?php $total_factures= 0?>
                            @foreach ($data->Invoice as $facture)
                            <li>Facture N°: {{ $facture->region."-".$facture->id."/".$facture->client->nom." ".$facture->client->prenom}} ({{ $facture->total_price }})</li>
                            <?php $total_factures += $facture->total_price;?>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $total_factures }}</td>
                    
                    {{-- Colonnes VERSEMENTS CAISSE (Droite) --}}
                    <td>
                        {{ $data->montant_gpl }}
                    </td>
                    <td>{{ $data->montant_consigne }}</td>
                    
                    <?php
                    $versement_total = $data->montant_gpl + $data->montant_consigne;
                    $total3 += $versement_total;
                    $total_gpl3 += $data->montant_gpl;
                    $total_consigne3 += $data->montant_consigne;
                    $total_com3 += $data->montantcom;
                    
                    // NOUVEAU CALCUL DE L'ÉCART
                    $ecart = $total_factures - $versement_total - $data->montantcom; // MODIFIÉ SELON VOTRE DEMANDE
                    
                    $total_ecart3 += $ecart;
                    $total_invoices3 +=$total_factures;
                    ?>
                    
                    <td>{{ $versement_total }}</td>
                    <td>{{ $data->bordereau }}</td>
                    <td>{{ $data->commentaire }}</td>
                    <td>{{$data->montantcom}}</td> 
                    <td style="{{ $ecart < 0 ? 'color: red;' : 'color: green;' }}">
                        {{ $ecart }}
                    </td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td>/</td>
                <td>/</td>
                <td>{{ number_format($total_invoices3, 2, ',', ' ') }}</td>
                <td>{{ $total_gpl3 }}</td>
                <td>{{ $total_consigne3 }}</td>
                <td>{{ number_format($total3, 2, ',', ' ') }}</td>
                <td>/</td>
                <td>/</td>
                <td>{{ number_format($total_com3, 2, ',', ' ') }}</td>
                <td>{{ number_format($total_ecart3, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>