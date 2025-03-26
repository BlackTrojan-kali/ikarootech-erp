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
        <h3>{{ Auth::user()->role }} :{{ Auth::user()->region }} </h3>
        <h4> FICHE HISTORIQUES PRODUCTTION GPL du {{ $fromDate }} au {{ $toDate }}</h4>

        <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="text-white font-bold bg-slate-600 p-2">
                <tr>
                    <td>S\L</td>
                    <td>Citerne</td>
                    <td>type</td>
                    <td>Qte</td>
                    <td>Qte * Type</td>
                    <td>Borde. Prod</td>
                    <td>date</td>
                </tr>
            </thead>
            <?php $totalqty = 0;
            $total = 0; ?>

            <tbody>
                @foreach ($datas as $data)
                    <tr id={{ $data->id }} class="hover:bg-blue-400 hover:text-white cursor-pointer">
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->citerne->name }} ({{ $data->citerne->type }})</td>
                        <td>{{ $data->type }}</td>
                        <td>{{ $data->qty }}</td>
                        <td>{{ $data->qty * $data->type }}</td>
                        <?php $totalqty += $data->qty * $data->type;
                        $total += $data->qty; ?>
                        <td>{{ $data->bordereau }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold">
                    <td colspan="2">Total des bouteilles produits</td>
                    <td colspan="2" style="text-align: right;">{{ $total }}</td>
                    <td colspan="3">{{ $totalqty }}</td>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>
