@extends('Layouts.controllerLayout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Liste des fermetures</h1>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border-b text-left">Date de début</th>
                <th class="py-2 px-4 border-b text-left">Date de fin</th>
                <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($closures as $closure)
                <tr>
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
