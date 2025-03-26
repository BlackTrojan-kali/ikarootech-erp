@extends('Layouts.DirectionLayout')
@section('content')
    <center>
        <h1 class="text-2xl font-bold"> {{ $type }} </h1>
        <div>
            <table class=" scroll text-center mt-10 w-full border-2 border-gray-400 border-collapse-0">
                <thead class="bg-gray-500 text-white p-2 border-collapse-0">
                    <tr>
                        <th>Date</th>
                        <th>QTE</th>
                        <th>Type Emballage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entrees as $entree)
                        <tr>
                            <td>{{ $entree->mois }}/{{ $entree->annee }} </td>
                            <td>{{ $entree->total_qty }}</td>
                            <td>{{ $entree->weight }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </center>
@endsection
