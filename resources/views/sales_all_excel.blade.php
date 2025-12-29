<table>
    <thead>
        <tr>
            <th rowspan="2">Client</th>
            <th colspan="2">6kg</th>
            <th colspan="2">12kg</th>
            <th colspan="2">50kg</th>
            <th rowspan="2">Prix Total</th>
            <th rowspan="2">Total Facture</th>
            <th rowspan="2">Date</th>
        </tr>
        <tr>
            <th>PU</th><th>QTE</th>
            <th>PU</th><th>QTE</th>
            <th>PU</th><th>QTE</th>
        </tr>
    </thead>
    <tbody>
        @php $invoices = $sales->groupBy('id_invoice'); @endphp
        @foreach($invoices as $invoiceTraces)
            @php
                $currentInvoice = $invoiceTraces->first()->invoice;
                $line = ['6kg' => ['pu' => 0, 'qty' => 0], '12kg' => ['pu' => 0, 'qty' => 0], '50kg' => ['pu' => 0, 'qty' => 0]];
                foreach ($invoiceTraces as $trace) {
                    $weight = (int)($trace->article->weight ?? 0);
                    if (in_array($weight, [6, 12, 50])) {
                        $line[$weight.'kg']['pu'] = $trace->unit_price;
                        $line[$weight.'kg']['qty'] += $trace->qty;
                    }
                }
            @endphp
            <tr>
                <td>{{ $currentInvoice->client->nom ?? 'N/D' }}</td>
                <td>{{ $line['6kg']['pu'] }}</td><td>{{ $line['6kg']['qty'] }}</td>
                <td>{{ $line['12kg']['pu'] }}</td><td>{{ $line['12kg']['qty'] }}</td>
                <td>{{ $line['50kg']['pu'] }}</td><td>{{ $line['50kg']['qty'] }}</td>
                <td>{{ $currentInvoice->total_price }}</td>
                <td>{{ $currentInvoice->total_price }}</td>
                <td>{{ $currentInvoice->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>