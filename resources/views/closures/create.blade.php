@extends('Layouts.controllerLayout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Creer une Periode de fermeture</h1>
    <form action="{{ route('closures.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-4">
            <label for="starting_date" class="block text-gray-700 font-bold mb-2">Date de début</label>
            <input type="date" name="starting_date" id="starting_date"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="ending_date" class="block text-gray-700 font-bold mb-2">Date de fin</label>
            <input type="date" name="ending_date" id="ending_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <select name="region" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach ($regions as $region )
                    <option value={{$region->region}} >{{$region->region}}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer les modifications
            </button>
            <a href="{{ route('closures.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
