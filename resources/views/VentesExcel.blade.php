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
        <h4> FICHE HISTORIQUE {{ strtoupper($type) }} du {{ $fromDate }} au {{ $toDate }}</h4>

        <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
        <table id="table-ventes" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 ">
            <thead class="p-3 bg-gray-500 text-white">
                <tr>
                    <th>
                        nom Client
                    </th>
                    <th colspan="6">
                        qtes vendus
                    </th>
                    <th>
                        prix total
                    </th>
                    <th>
                        date
                    </th>
                </tr>
                <tr class="border  border-black">
                    <th class="border  border-black">/</th>
                    <th class="border  border-black" colspan="2">50 KG</th>
                    <th class="border  border-black" colspan="2">12.5 KG</th>
                    <th class="border  border-black" colspan="2">6 KG</th>
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">/</th>
                </tr>
                <tr class="border  border-black">
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">Prix U</th>
                    <th class="border  border-black">Qte</th>
                    <th class="border  border-black">Prix U</th>
                    <th class="border  border-black">Qte</th>
                    <th class="border  border-black">Prix U</th>
                    <th class="border  border-black">Qte</th>
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">/</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $total_qty_6 = 0;
                $total_qty_12 = 0;
                $total_qty_50 = 0;
                ?>
                @foreach ($sales as $vente)
                    <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                        <td class="border  border-black">{{ $vente->customer }}</td>
                        <td class="border  border-black">{{ number_format($vente->prix_50, 2, ',', ' ') }}</td>
                        <td class="border  border-black">{{ $vente->qty_50 }}</td>
                        <td class="border  border-black">{{ number_format($vente->prix_12, 2, ',', ' ') }}</td>
                        <td class="border  border-black">{{ $vente->qty_12 }}</td>
                        <td class="border  border-black">{{ number_format($vente->prix_6, 2, ',', ' ') }}</td>
                        <td class="border  border-black">{{ $vente->qty_6 }}</td>
                        <td class="border  border-black">
                            {{ number_format($vente->prix_6 * $vente->qty_6 + $vente->prix_12 * $vente->qty_12 + $vente->prix_50 * $vente->qty_50, 2, ',', ' ') }}
                            <?php
                            $UnitTotal = $vente->prix_6 * $vente->qty_6 + $vente->prix_12 * $vente->qty_12 + $vente->prix_50 * $vente->qty_50;
                            $total += $UnitTotal;
                            $total_qty_6 += $vente->qty_6;
                            $total_qty_12 += $vente->qty_12;
                            $total_qty_50 += $vente->qty_50;
                            ?>
                        </td>
                        <td class="border  border-black">{{ $vente->created_at }}</td>

                    </tr>
                @endforeach

                <tr>
                    <td><b>TOTAL</b></td>
                    <td colspan="2" style="text-align: right;"><b>{{ $total_qty_50 }}</b></td>
                    <td colspan="2" style="text-align: right;"><b>{{ $total_qty_12 }}</b></td>
                    <td colspan="2" style="text-align: right;"><b>{{ $total_qty_6 }} </b></td>
                    <td colspan="2" style="text-align: center"><b>{{ number_format($total, 2, ',', ' ') }} XAF</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
</body>

</html>
