@extends('Layouts.controllerLayout')

@section('content')
<div class="p-6">
    <div class="w-full flex justify-between">
    <h1 class="text-2xl font-bold mb-4">Liste des fermetures</h1>
    <a href={{route("closures.create")}} class="bg-green-500 px-4 py-2 w-[100px] text-white text-center">
    Creer
</a>   
</div>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border-b text-left">Region</th>
                <th class="py-2 px-4 border-b text-left">Date de début</th>
                <th class="py-2 px-4 border-b text-left">Date de fin</th>
                <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($closures as $closure)
                <tr>
                    <td class="py-2 px-4 border-b">{{$closure->region}}</td>
                    <td class="py-2 px-4 border-b">{{ $closure->starting_date }}</td>
                    <td class="py-2 px-4 border-b">{{ $closure->ending_date }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('closures.edit', $closure->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                            Modifier
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
