@extends('Layouts.DirectionLayout')
@section('content')
    <center>
        <div class="flex flex-row justify-between p-4">
            <h1 class="text-2xl font-bold">Versements Global {{ $type }}</h1>

            <button class="ternary p-2 text-white rounded-sm text-bold"><a href="{{ route('CaPDFForm') }}">generer un
                    PDF</a></button>
        </div>
        <div>
            <table class=" scroll text-center mt-10 w-full border-2 border-gray-400 border-collapse-0">
                <thead class="bg-gray-500 text-white p-2 border-collapse-0 ">
                    <tr>
                        <th>Date</th>
                        <th>Versements</th>
                        <th>Consigne</th>
                        <th>Total Factures</th>
                        <th>Ecart</th>
                        <th>Bank</th>
                    </tr>
                </thead>
                <tbody class="text-start">
                    @foreach ($versements as $versement)
                        <tr>
                            <td>{{ $versement->mois }}/{{ $versement->annee }} </td>
                            <td>{{ number_format($versement->total_gpl, 2, ',', ' ') }}</td>
                            <td>{{ number_format($versement->total_consigne, 2, ',', ' ') }}</td>
                           
                            <td>{{$versement->total_factures}}</td>
                            <?php $ecart = $versement->total_factures - ($versement->total_gpl+$versement->total_consigne);?>
                            <td class="{{ $ecart >0? "text-green-500":"text-red-500" }}">{{$ecart}}</td>
                            <td>{{ $versement->bank }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </center>
@endsection
