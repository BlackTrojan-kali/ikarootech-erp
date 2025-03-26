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
        .table-2 {
            border: 2px solid black;

        }

        .table-1 th,
        .table-2 th {
            font-size: 0.8rem;

        }

        .table-1 th,
        .table-1 tr,
        .table-1 td,
        .table-2 th,
        .table-2 tr,
        .table-2 td {
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
        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo.png'))) }}"
            width="100px">
            <p>
                <b>{{ env('COMPANIE_NAME') }}</b><br>
                <b>B.P:</b>{{ env('COMPANIE_ADDRESS') }} <br>
                <b>Tél:</b>{{ env('COMPANIE_CANTACT_1') }} <br>
                <b>Email:</b> {{ env('COMPANIE_EMAIL_1') }} <br>
            </p>
    </div>
    <center>
        <h3>{{ $service }} :{{ $region }} </h3 <h4> FICHE DE STOCK GLOBAL {{ $first->type }}
        {{ $first->weight }} KG du {{ $fromdate }} au {{ $todate }}</h4>

    </center>

    <center>
        <h1><u> Bouteilles Vides</u></h1>
    </center>
    <table class="table-1">
        <thead>
            <tr>
                <th colspan="3">MVT DU STOCK TOTAL</th>
                <th><b>DATES</b></th>
                <th><b>LIBELLES</b></th>
                <th colspan="3">MVT EN MAGASIN DES BOUTEILLES VIDES</th>
            </tr>
            <tr>
                <th>Achats</th>
                <th>Cons.</th>
                <th>Pertes</th>
                <th>

                </th>
                <th> </th>
                <th>ENTREES</th>
                <th>SORTIES</th>
                <th><b>STOCKS</b></th>
            </tr>
        </thead>
        <?php
        $total_achat = 0;
        $total_consigne1 = 0;
        $total_perte1 = 0; ?>
        <tr class="head-color">
            <td></td>
            <td></td>
            <td></td>
            <td>

            </td>
            <td> </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <?php $sommeEntryV = 0;
        $sommeOutcomeV = 0; ?>
        <tbody>
            @foreach ($bouteille_vides as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>

                        {{ $data->origin == 'achat' ? $data->qty : 0 }}
                    </td>

                    <td>
                        <?php
                        if ($data->origin == 'consigne') {
                            $total_consigne1 += $data->qty;
                        } elseif ($data->origin == 'pertes') {
                            $total_perte1 += $data->qty;
                        } elseif ($data->origin == 'achat') {
                            $total_achat += $data->qty;
                        }
                        ?>
                        {{ $data->origin == 'consigne' ? $data->qty : 0 }}
                    </td>
                    <td>
                        {{ $data->origin == 'pertes' ? $data->qty : 0 }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->label }}</td>
                    <?php
                    if ($data->entree) {
                        $sommeEntryV += $data->qty;
                    } else {
                        $sommeOutcomeV += $data->qty;
                    }
                    ?>
                    <td>{{ $data->entree >= 1 ? $data->qty : 0 }}</td>
                    <td>{{ $data->entree == 0 ? $data->qty : 0 }}</td>
                    <td>{{ $data->stock }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>{{ $total_achat }}</b></td>
                <td><b>{{ $total_consigne1 }}</b></td>
                <td><b>{{ $total_perte1 }}</b></td>
                <td colspan="2"> <b>Total Mouvements</b></td>
                <td><b>{{ $sommeEntryV }}</b></td>
                <td><b>{{ $sommeOutcomeV }}</b></td>
                <td>/</td>
            </tr>
        </tbody>
    </table>

    <!--second table-->
    <center>
        <h1><u> Bouteilles Pleines</u></h1>
    </center>

    <table class="table-1">
        <thead>
            <tr>
                <th colspan="3">MVT DU STOCK TOTAL</th>
                <th><b>DATES</b></th>
                <th><b>LIBELLES</b></th>
                <th colspan="3">MVT EN MAGASIN DES BOUTEILLES PLEINES</th>
            </tr>
            <tr>
                <th>Achats</th>
                <th>Cons.</th>
                <th>Pertes</th>
                <th>

                </th>
                <th> </th>
                <th>ENTREES</th>
                <th>SORTIES</th>
                <th><b>STOCKS</b></th>
            </tr>
        </thead>
        <tr class="head-color">
            <td></td>
            <td></td>
            <td></td>
            <td>

            </td>
            <td> </td>
            <td></td>
            <td></td>
            <td></td>


        </tr>

        <?php $sommeEntry = 0;
        $sommeOutcome = 0;
        $total_achat2 = 0; // total achat pleines
        $total_consigne2 = 0;
        $total_perte2 = 0; ?>
        <tbody>
            @foreach ($bouteille_pleines as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>
                        {{ $data->origin == 'achat' ? $data->qty : 0 }}
                    </td>
                    <?php
                    if ($data->origin == 'consigne') {
                        $total_consigne2 += $data->qty;
                    } elseif ($data->origin == 'pertes') {
                        $total_perte2 += $data->qty;
                    } elseif ($data->origin == 'achat') {
                        $total_achat2 += $data->qty;
                    }
                    ?>
                    <td>
                        {{ $data->origin == 'consigne' ? $data->qty : 0 }}
                    </td>
                    <td>
                        {{ $data->origin == 'pertes' ? $data->qty : 0 }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->label }}</td>
                    <?php
                    if ($data->entree) {
                        $sommeEntry += $data->qty;
                    } else {
                        $sommeOutcome += $data->qty;
                    }
                    ?>
                    <td>{{ $data->entree >= 1 ? $data->qty : 0 }}</td>
                    <td>{{ $data->entree == 0 ? $data->qty : 0 }}</td>
                    <td>{{ $data->stock }}</td>
                </tr>
            @endforeach

            <tr>
                <td><b>{{ $total_achat2 }}</b></td>
                <td><b>{{ $total_consigne2 }}</b></td>
                <td><b>{{ $total_perte2 }}</b></td>
                <td colspan="2"> <b>Total Mouvements</b></td>
                <td><b>{{ $sommeEntry }}</b></td>
                <td><b>{{ $sommeOutcome }}</b></td>
                <td>/</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
