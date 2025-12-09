<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Ventes - Tous Articles</title>
    <style>
        /* Style minimal pour le PDF */
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            vertical-align: top;
        }

        thead th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        tfoot td {
            font-weight: bold;
            background-color: #e0e0e0;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>

<header style="text-align: center; margin-bottom: 20px;">
    <h2>Rapport de Ventes (Tous Articles)</h2>
    <p>Période du {{ $fromDate->format('d/m/Y') }} au {{ $toDate->format('d/m/Y') }}</p>
    <p>Type de vente : {{ strtoupper($type) }}</p>
</header>

@php
    // Regrouper les traces par Facture (id_invoice)
    $invoices = $sales->groupBy('id_invoice'); 
    
    // Initialisation des totaux généraux
    $totalQty6kg = 0;
    $totalQty12kg = 0;
    $totalQty50kg = 0;
    $grandTotalPrice = 0;
    $grandTotalInvoice = 0;
@endphp

<table>
    <thead>
        <tr>
            <th rowspan="2" style="width: 15%;">Client</th>
            <th colspan="6">Articles</th>
            <th rowspan="2" style="width: 10%;">Prix Total</th>
            <th rowspan="2" style="width: 10%;">Total Facture</th>
            <th rowspan="2" style="width: 10%;">Date</th>
        </tr>
        <tr>
            <th style="width: 8%;">6kg <br> PU</th>
            <th style="width: 5%;">6kg <br> QTE</th>
            <th style="width: 8%;">12kg <br> PU</th>
            <th style="width: 5%;">12kg <br> QTE</th>
            <th style="width: 8%;">50kg <br> PU</th>
            <th style="width: 5%;">50kg <br> QTE</th>
        </tr>
    </thead>
    <tbody>
        {{-- Boucle sur chaque Facture (groupe de traces) --}}
        @foreach($invoices as $invoiceId => $invoiceTraces)
            @php
                // Récupération de l'objet Facture parent (et Client)
                $currentInvoice = $invoiceTraces->first()->invoice; 
                $invoiceDate = \Carbon\Carbon::parse($currentInvoice->created_at);

                // Initialisation des données pour cette ligne de tableau
                $line = [
                    'client' => $currentInvoice->client->nom ?? 'N/D',
                    'date' => $invoiceDate->format('Y-m-d') . ' <br> ' . $invoiceDate->format('H:i:s'),
                    // Utilisation des propriétés de la facture (Invoices model)
                    'total_price' => number_format($currentInvoice->total_price, 0, ',', ' '),
                    'total_invoice' => number_format($currentInvoice->total_price, 0, ',', ' '), 
                    'articles' => [
                        '6kg' => ['pu' => null, 'qty' => 0], 
                        '12kg' => ['pu' => null, 'qty' => 0],
                        '50kg' => ['pu' => null, 'qty' => 0],
                    ],
                ];

                // Parcours de toutes les traces liées à cette facture pour agréger par Poids
                foreach ($invoiceTraces as $trace) {
                    // Assurez-vous que l'article et la propriété weight existent
                    $weight = (int) ($trace->article->weight ?? 0); 
                    $qty = $trace->qty;
                    $unitPrice = $trace->unit_price;
                    
                    if ($weight == 6) {
                        $line['articles']['6kg']['pu'] = number_format($unitPrice, 0, ',', ' ');
                        $line['articles']['6kg']['qty'] += $qty;
                        $totalQty6kg += $qty;
                    } elseif ($weight == 12) {
                        $line['articles']['12kg']['pu'] = number_format($unitPrice, 0, ',', ' ');
                        $line['articles']['12kg']['qty'] += $qty;
                        $totalQty12kg += $qty;
                    } elseif ($weight == 50) {
                        $line['articles']['50kg']['pu'] = number_format($unitPrice, 0, ',', ' ');
                        $line['articles']['50kg']['qty'] += $qty;
                        $totalQty50kg += $qty;
                    }
                }
                
                // Mise à jour des totaux généraux
                $grandTotalPrice += $currentInvoice->total_price;
                $grandTotalInvoice += $currentInvoice->total_price;
            @endphp
            
            <tr>
                {{-- Client --}}
                <td class="text-left">{{ $line['client'] }}</td>
                
                {{-- 6kg (PU & QTE) --}}
                <td>{{ $line['articles']['6kg']['pu'] ?? '0' }}</td> 
                <td>{{ $line['articles']['6kg']['qty'] > 0 ? $line['articles']['6kg']['qty'] : '0' }}</td>

                {{-- 12kg (PU & QTE) --}}
                <td>{{ $line['articles']['12kg']['pu'] ?? '0' }}</td>
                <td>{{ $line['articles']['12kg']['qty'] > 0 ? $line['articles']['12kg']['qty'] : '0' }}</td>

                {{-- 50kg (PU & QTE) --}}
                <td>{{ $line['articles']['50kg']['pu'] ?? '0' }}</td>
                <td>{{ $line['articles']['50kg']['qty'] > 0 ? $line['articles']['50kg']['qty'] : '0' }}</td>
                
                {{-- Totaux Facture --}}
                <td>{{ $line['total_price'] }}</td>
                <td>{{ $line['total_invoice'] }}</td>
                <td>{!! $line['date'] !!}</td> 
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">TOTAL GÉNÉRAL</td>
            <td>{{ $totalQty6kg }}</td> {{-- Total QTE 6kg --}}
            <td colspan="1"></td>
            <td>{{ $totalQty12kg }}</td> {{-- Total QTE 12kg --}}
            <td colspan="1"></td>
            <td>{{ $totalQty50kg }}</td> {{-- Total QTE 50kg --}}
            <td>{{ number_format($grandTotalPrice, 0, ',', ' ') }}</td>
            <td>{{ number_format($grandTotalInvoice, 0, ',', ' ') }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

</body>
</html>