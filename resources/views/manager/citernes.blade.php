@extends('Layouts.ManagerLayout')
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
                    <td>Action</td>
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
                        <td>
                            <a href="{{ route('makeRel', ['id' => $fix->id]) }}">
                                <button class="bg-blue-400 p-2 text-white rounded-md">Nouveau releve</button>
                            </a>
                            <a href="{{ route('modif', ['id' => $fix->id]) }}">
                                <button class="bg-blue-400 p-2 text-white rounded-md">Modifier Stock Theo

                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </center>
@endsection
