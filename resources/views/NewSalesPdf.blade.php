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
        <h4> FICHE HISTORIQUE {{ strtoupper($type) }} du {{ $fromDate }} au {{ $toDate }}</h4>

        <!-- Neo  invoices -->
        <table id="table-invoices" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 ">
            <thead class="p-3 bg-gray-500 text-white">
                <tr>
                    <th>
                        nom Client
                    </th>
                    <th class="border  border-black">Article</th>
                    <th class="border  border-black">PU</th>
                    <th class="border  border-black">Qte</th>

                    <th>
                        prix total
                    </th>
                    <th>
                        total facture
                    </th>
                    <th>
                        encaissé
                    </th>
                    <th>
                        ecart
                    </th>
                    <th>
                        date
                    </th>
            </thead>
            <tbody>

                @foreach ($sales as $sale)
                    <tr id="{{ $sale->invoice->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                        <?php $total_unit = 0; ?>
                        <td class="border  border-black">{{ $sale->nom . ' ' . $sale->prenom }}</td>
                        <td class="border  border-black">
                            {{ $sale->article->type == 'accessoire' ? $sale->article->title : $sale->article->weight . ' KG' }}
                        </td>
                        <td class="border  border-black">{{ $sale->unit_price }}</td>
                        <td class="border  border-black">{{ $sale->qty }}</td>
                        <td class="border  border-black">
                            <?php $total_unit = $sale->unit_price * $sale->qty; ?>
                            {{ $total_unit }}
                        </td>
                        <td class="border  border-black">
                            {{ $sale->invoice->total_price }}
                        </td>
                        <td class="border  border-black">
                            {{ $sale->recieved }}
                        </td>
                        <td class="border  border-black">
                            <?php $ecart = $sale->recieved - $sale->invoice->total_price; ?>
                            @if ($ecart >= 0)
                                <p class="text-blue-400">{{ $ecart }}</p>
                            @else
                                <p class="text-red-500">{{ $ecart }}</p>
                            @endif
                        </td>
                        <td class="border  border-black">{{ $sale->created_at }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </center>
</body>

</html>
