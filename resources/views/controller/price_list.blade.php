<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liste de Prix</title>
    <style>
        /* La police DejaVu Sans est utilisée pour s'assurer que Dompdf gère correctement les caractères spéciaux (comme les accents) */
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10pt;
        }
        h1, h2 { 
            text-align: center; 
            color: #2c3e50; /* Couleur sombre pour le professionnalisme */
        }
        h1 {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #bdc3c7;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .filter-info {
            margin-top: 10px;
            text-align: center;
            font-weight: 600;
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 50px;
            font-size: 8pt;
            text-align: center;
            line-height: 35px;
            border-top: 1px solid #bdc3c7;
        }
    </style>
</head>
<body>

    <h1>LISTE DES PRIX SPÉCIFIQUES</h1>

    <div class="filter-info">
        <h2>Catégorie Client : {{ $categoryName }}</h2>

        @if ($filterArticle)
            <p>Article Filtré : {{ $filterArticle }}</p>
        @else
            <p>Affichage de tous les articles pour cette catégorie.</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Article (Type)</th>
                <th>Poids</th>
                <th>Région</th>
                <th>Prix GPL (Unité)</th>
                <th>Prix Consigne</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prices as $price)
                <tr>
                    <td>
                        {{-- Affichage du titre pour les accessoires, ou du type pour le reste --}}
                        @if ($price->article->type == 'accessoire')
                            {{ $price->article->title }}
                        @else
                            {{ $price->article->type }}
                        @endif
                    </td>
                    <td>
                        {{-- Affichage du poids si ce n'est pas un accessoire --}}
                        @if ($price->article->type != 'accessoire')
                            {{ $price->article->weight . ' KG' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $price->region }}</td>
                    
                    {{-- Formatage des prix en XAF --}}
                    <td>{{ number_format($price->unite_price, 0, ',', ' ') }} XAF</td>
                    <td>{{ number_format($price->consigne_price, 0, ',', ' ') }} XAF</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Document généré par le système le : {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>
</html>