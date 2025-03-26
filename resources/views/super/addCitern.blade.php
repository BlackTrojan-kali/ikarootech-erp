@extends("Layouts.appLayout")
@section('content')
<center>
    <h1 class="font-bold text-2xl mb-4">Enregitrer une nouvelle citerne</h1>
    <form action="{{route("validateCiterns")}}" method="POST" class="w-96 border-2 border-blue-400 rounded-md p-4">
        @csrf
        <div class="champs">
            <label for="">Nom:</label>
            <input type="text" name="name" id="">
            @if ($errors->has("name"))
                <span class="text-red-500">{{$errors->first("name")}}</span>
            @endif
        </div>
        <div class="champs">
            <label for="">Capacité en KG:</label>
            <input type="number" name="capacity" id="">
            @if ($errors->has("capacity"))
                <span class="text-red-500">{{$errors->first("name")}}</span>
            @endif
        </div>
        <div class="champs">
            <label for="">Type</label>
            <select name="type" id="" class="w-full p-2 h-10">
                <option value="mobile">Mobile</option>
                <option value="fixe">Fixe</option>
            </select>

            @if ($errors->has("type"))
                <span class="text-red-500">{{$errors->first("type")}}</span>
            @endif
        </div>
        <div class="flex justify-between mt-7">
            <button type="reset" class="p-2 text-white bg-blue-400">Annuler</button>
            <button type="submit" class="p-2 text-white bg-blue-400">Enregistrer</button>
        </div>
    </form>
</center>
@endsection