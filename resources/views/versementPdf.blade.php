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
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            font-size: 0.8rem;
        }

        th,
        tr,
        td {
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
        <img src="{{ public_path('images/logo.png') }}"
            width="100px">
        <p>
            <b>{{ env('COMPANIE_NAME') }}</b><br>
            <b>B.P:</b>{{ env('COMPANIE_ADDRESS') }} <br>
            <b>Tél:</b>{{ env('COMPANIE_CANTACT_1') }} <br>
            <b>Email:</b> {{ env('COMPANIE_EMAIL_1') }} <br>
        </p>
    </div>
    <center>
        <h3>{{ Auth::user()->role }} :{{ Auth::user()->region }} -Banque: {{ $bank }}</h3>
        <h4> FICHE HISTORIQUES DES VERSEMENTS du {{ $fromDate }} au {{ $toDate }}</h4>

        <table>
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
                @foreach ($deposit as $data)
                    
                    {{-- Calcul des totaux et de l'écart AVANT l'affichage de la ligne --}}
                    <?php 
                    $total_factures= 0;
                    foreach ($data->Invoice as $facture) {
                        $total_factures += $facture->total_price;
                    }

                    $versement_total = $data->montant_gpl + $data->montant_consigne;

                    // Formule CORRIGÉE selon votre demande : (Total Versement + Total Commentaire) - Total Factures
                    $ecart = ($versement_total + $data->montantcom) - $total_factures; // CORRIGÉ
                    
                    // Mise à jour des totaux globaux
                    $total1 += $versement_total;
                    $total_gpl1 += $data->montant_gpl;
                    $total_consigne1 += $data->montant_consigne;
                    $total_com1 += $data->montantcom;
                    
                    $total_ecart1 += $ecart;
                    $total_invoices1 +=$total_factures;
                    ?>
                    
                    <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                        {{-- DATES --}}
                        <td>
                            {{ $data->created_at }}
                        </td>
                        
                        {{-- Factures Associées --}}
                        <td>
                            <ul>
                                @foreach ($data->Invoice as $facture)
                                    <li>Facture N°: {{ $facture->region."-".$facture->id."/".$facture->client->nom." ".$facture->client->prenom}} ({{ $facture->total_price }})</li>
                                @endforeach
                            </ul>
                        </td>
                        
                        {{-- Total Factures --}}
                        <td>{{ $total_factures }}</td>

                        {{-- GPL --}}
                        <td>
                            {{ $data->montant_gpl }}
                        </td>
                        
                        {{-- Consigne --}}
                        <td>{{ $data->montant_consigne }}</td>
                        
                        {{-- Total Versement --}}
                        <td>{{ $versement_total }}</td>
                        
                        {{-- Bordereau --}}
                        <td>{{$data->bordereau}}</td>
                        
                        {{-- Commentaire --}}
                        <td>{{ $data->commentaire }}</td>
                        
                        {{-- Total Commentaire --}}
                        <td>{{$data->montantcom}}</td>
                        
                        {{-- Écart (Affichage) --}}
                        <td style="{{ $ecart < 0 ? 'color: red;' : 'color: green;' }}">
                            {{ $ecart }}
                        </td>
                    </tr>
                @endforeach
                {{-- Ligne de totaux --}}
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
    </center>
</body>

</html>