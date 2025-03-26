@extends('Layouts.ManagerLayout')
@section('content')
    <center>
        <div class="w-4/12 border-2 border-black p-5 text-start relative">
            <a href="{{ Auth::user()->role == 'producer' ? route('showCiterne') : route('showCiterneMan') }}"
                class="bg-gray-500 p-2 rounded-full text-white">retour</a>
            <h1 class="text-center font-bold text-2xl">Modifier le stock theorique</h1>
            <form action="{{ route('postModif', $citerne->id) }}" method="POST">
                @csrf
                <br>
                <div class="">
                    <label for="" class="text-2xl">Nom Citerne:</label><br>
                    <span class="font-bold text-blue-400  text-xl">{{ $citerne->name }}</span>
                </div>
                <div class="">
                    <label for="" class="text-xl">qte theo:</label><br>
                    <input type="number" placeholder="quantite relever " name="qty"
                        class="p-2 w-full border  border-black mt-2 h-10">
                    @if ($errors->has('qty'))
                        <span>{{ $errors->first('qty') }}</span>
                    @endif
                </div>

                <br>
                <div class="text-end">

                    <button class="bg-gray-400 p-2 text-white">appliquer</button>
                </div>
            </form>
        </div>
    </center>
@endsection
