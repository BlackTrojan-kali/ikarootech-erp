@extends('Layouts.controllerLayout')
@section('content')
    <center>
        <h1 class="font-bold text-2xl">Etat du Stock</h1>
        <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="text-white font-bold text-center bg-slate-600 p-2">
                <tr>
                    <td>S/L</td>
                    <td>Citerne</td>
                    <td>Stock Theo</td>
                    <td>Stock Releve</td>
                    <td>Ecart</td>
                </tr>
            </thead>
            <tbody class="bg-orange-200 text-center">
                @foreach ($fixe as $fix)
                    <tr>
                        <td>{{ $fix->id }}</td>
                        <td>{{ $fix->name }}-{{ $fix->type }}</td>
                        <td>{{ $fix->stock[0]->stock_theo }}</td>
                        <td>{{ $fix->stock[0]->stock_rel }}</td>

                        <?php
                        $ecart = $fix->stock[0]->stock_rel - $fix->stock[0]->stock_theo;
                        ?>
                        <td>
                            @if ($ecart > 0)
                                <span class="text-green-500">{{ $ecart }}</span>
                            @else
                                <span class="text-red-500">{{ $ecart }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </center>
@endsection
