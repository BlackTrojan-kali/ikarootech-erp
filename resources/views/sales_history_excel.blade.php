<table>
    <thead>
        <tr>
            <th>Nom Client</th>
            <th>Article</th>
            <th>PU</th>
            <th>Qte</th>
            <th>Prix Total</th>
            <th>Total Facture</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->invoice->client->nom }} {{ $sale->invoice->client->prenom }}</td>
                <td>{{ $sale->article->type == 'accessoire' ? $sale->article->title : $sale->article->weight . ' KG' }}</td>
                <td>{{ $sale->unit_price }}</td>
                <td>{{ $sale->qty }}</td>
                <td>{{ $sale->unit_price * $sale->qty }}</td>
                <td>{{ $sale->invoice->total_price }}</td>
                <td>{{ $sale->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>