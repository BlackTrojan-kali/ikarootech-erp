@extends("Layouts.appLayout")
@section('content')
<center>
    <h1 class="text-xl font-bold">Ajouter une nouvelle Region</h1>
    <form action="{{route('store-region')}}" method="post" class="md:w-4/12 border-2 mt-2 p-5 border-blue-400 rounded-md">
        @csrf
        <div class="champs">
            <label for="username">Nom:</label>
            <input type="text" name="region" required>
            @if ($errors->has("region"))
                <p class="text-red-500"> {{$errors->first('region')}}</p>
            @endif
        </div>
        </div>
        <div class="w-full flex justify-between mt-4">
            <button type="reset" class="p-2 bg-black text-white">Annuler</button>
            <button type="submit" class="p-2 bg-blue-400 text-white">Enregistrer</button>
        </div>
    </form>
</center>
@endsection