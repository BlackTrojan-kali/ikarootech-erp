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
        <h3>{{ strtoupper(Auth::user()->role) }} :{{ strtoupper(Auth::user()->region) }} </h3 <h4> FICHE DE VERSEMENTS
        GLOBAL</h4>

    </center>
    <center><u>
            <h1>AFB BANK</h1>
        </u></center>
    <table class="table-1">
        <thead>
            <th colspan="5">VERSEMENTS AFB</th>
            <tr>
                <th><b>DATES</b></th>
                <th><b>GPL</b></th>
                <th><b>Consigne</b></th>
                <th><b>Total</b></th>
                <th><b>Commentaire</b></th>
            </tr>
        </thead>

        <?php $total1 = 0;
        $total_gpl1 = 0;
        $total_consigne1 = 0; ?>
        <tbody>
            @foreach ($afb as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>
                        {{ $data->created_at }}
                    </td>

                    <td>
                        {{ $data->montant_gpl }}
                    </td>
                    <td>{{ $data->montant_consigne }}</td>

                    <?php
                    $total1 += $data->montant_gpl + $data->montant_consigne;
                    $total_gpl1 += $data->montant_gpl;
                    $total_consigne1 += $data->montant_consigne;
                    ?>
                    <td>{{ $data->montant_gpl + $data->montant_consigne }}</td>
                    <td>{{ $data->commentaire }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td>/</td>
                <td>{{ $total_gpl1 }}</td>
                <td>{{ $total_consigne1 }}</td>
                <td>{{ number_format($total1, 2, ',', ' ') }}</td>
                <td>/</td>
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
            <th colspan="5">VERSEMENTS CCA</th>
            <tr>
                <th><b>DATES</b></th>
                <th><b>GPL</b></th>
                <th><b>Consigne</b></th>
                <th><b>Total</b></th>
                <th><b>Commentaire</b></th>
            </tr>
        </thead>
        <?php $total = 0;
        $total_gpl = 0;
        $total_consigne = 0; ?>
        <tbody>
            @foreach ($cca as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>
                        {{ $data->created_at }}
                    </td>

                    <td>
                        {{ $data->montant_gpl }}
                    </td>
                    <td>{{ $data->montant_consigne }}</td>
                    <td>
                        <?php
                        $total += $data->montant_gpl + $data->montant_consigne;
                        $total_gpl += $data->montant_gpl;
                        $total_consigne += $data->montant_consigne;
                        ?>
                        {{ $data->montant_gpl + $data->montant_consigne }}</td>
                    <td>{{ $data->commentaire }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td>/</td>
                <td>{{ $total_gpl }}</td>
                <td>{{ $total_consigne }}</td>
                <td>{{ number_format($total, 2, ',', ' ') }}</td>
                <td>/</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
