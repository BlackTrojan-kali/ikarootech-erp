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

    <center>
        <h3>{{ strtoupper(Auth::user()->role) }} :{{ strtoupper(Auth::user()->region) }} </h3>
        <h4> FICHE DE VERSEMENTS
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

    <center>
        <u>
            <h1>CAISSE</h1>
        </u>
    </center>
    <table class="table-3">
        <thead>
            <th colspan="5">VERSEMENTS CAISSE</th>
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
        $total_caisse = 0; ?>
        <tbody>
            @foreach ($caisse as $data)
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
                        $total_caisse += $data->montant_consigne;
                        ?>
                        {{ $data->montant_gpl + $data->montant_consigne }}</td>
                    <td>{{ $data->commentaire }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold;">
                <td>/</td>
                <td>{{ $total_gpl }}</td>
                <td>{{ $total_caisse }}</td>
                <td>{{ number_format($total, 2, ',', ' ') }}</td>
                <td>/</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
