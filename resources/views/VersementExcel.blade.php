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


    <center>
        <h3>{{ Auth::user()->role }} :{{ Auth::user()->region }} -Banque: {{ $bank }}</h3>
        <h4> FICHE HISTORIQUES DES VERSEMENTS du {{ $fromDate }} au {{ $toDate }}</h4>

        <table>
            <thead>
                <th>No:</th>
                <th>GPL</th>
                <th>CONSIGNE</th>
                <th>TOTAL</th>
                <th>COMMENTAIRE</th>
                <th>BORDEREAU</th>
                <th>Date</th>
            </thead>
            <?php
            $total_gpl = 0;
            $total_consigne = 0;
            $total_total = 0;
            ?>
            <tbody>
                @foreach ($deposit as $data)
                    <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                        <td>{{ $data->id }}</td>
                        <?php
                        $total_gpl += $data->montant_gpl;
                        $total_consigne += $data->montant_consigne;
                        $total_total += $data->montant_gpl + $data->montant_consigne;
                        ?>
                        <td>{{ number_format($data->montant_gpl, 2, ',', ' ') }}</td>
                        <td>{{ number_format($data->montant_consigne, 2, ',', ' ') }}</td>
                        <td>{{ number_format($data->montant_gpl + $data->montant_consigne, 2, ',', ' ') }}</td>
                        <td>{{ $data->commentaire }}</td>
                        <td>{{ $data->bordereau }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>/</td>
                    <td><b>{{ number_format($total_gpl, 2, ',', ' ') }}</b></td>
                    <td><b>{{ number_format($total_consigne, 2, ',', ' ') }}</b></td>
                    <td><b>{{ number_format($total_total, 2, ',', ' ') }}</b></td>
                    <td>/</td>
                    <td>/</td>
                    <td>/</td>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>
