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
        <h3>{{ Auth::user()->role }} :{{ Auth::user()->region }} </h3>
        <h4> FICHE HISTORIQUES RECEPTION GPL VRAC du {{ $fromDate }} au {{ $toDate }}</h4>

        <table>
            <thead>
                <th>No:</th>
                <th>Citerne</th>
                <th>Qte</th>
                <?php $total_Qte = 0; ?>
                <th>Reception</th>
                <th>Provenance</th>
                <th>Matricule Veh.</th>
                <th>Borde. Livraison</th>
                <th>Date</th>
            </thead>
            <tbody>
                @foreach ($receive as $data)
                    <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->citerne->name }}</td>
                        <?php $total_Qte += $data->qty; ?>
                        <td>{{ $data->qty }}</td>
                        <td>{{ $data->receiver }}</td>
                        <td>{{ $data->provenance }}</td>
                        <td>{{ $data->matricule }}</td>
                        <td>{{ $data->livraison }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>/</td>
                    <td>/</td>
                    <td><b>{{ $total_Qte }}</b></td>
                    <td>/</td>
                    <td>/</td>
                    <td>/</td>
                    <td>/</td>
                    <td>/</td>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>
