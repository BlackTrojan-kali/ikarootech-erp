@extends("Layouts.appLayout")
@section("content")

<center class="w-full p-4">
    <h1 class="mb-3 text-xl font-bold">Enregistrer un nouveau produit</h1>
    <form action="{{route("insertArticle")}}" method="POST" class="p-4 border border-blue-400 rounded-lg w-5/12">
        @csrf
        <div class="champs">
            <label for="title">Nom:</label>
            <input type="text" name="title" required>
            @if ($errors->has("title"))
                <p class="text-red-500">{{$errors->first('title')}}</p>
            @endif
        </div>
        <div class="champs">
            <label for="title">Unite:</label>
            <select name="unity" class="w-full p-3 font-bold" id="">
                <option value="KG" selected> Kg</option>
                <option value="L">L</option>
            </select>
            @if ($errors->has("unity"))
                <p class="text-red-500">{{$errors->first('unity')}}</p>
            @endif
        </div>
        <div class="champs">
            <label for="title">Famille :</label>
            <select name="family" class="w-full p-3 font-bold" id="">
                <option value="" selected>NONE</option>
                @foreach ($families as $family )
                    
                <option value={{$family->name  }}>{{ $family->name }}</option>
                @endforeach
            </select>
            @if ($errors->has("family"))
                <p class="text-red-500">{{$errors->first('family')}}</p>
            @endif
        </div>
        <div class="champs hidden">
            <label for="title">Poids:</label>
            <select name="poids" class="w-full p-3 font-bold" id="">
                <option value="12.5" selected>12.5 Kg</option>
                <option value="50">50 Kg</option>
                <option value="6">6 Kg</option>
            </select>
            @if ($errors->has("poids"))
                <p class="text-red-500">{{$errors->first('poids')}}</p>
            @endif
        </div>
        <div class="champ text-start my-4 font-bold hidden">
        <label for="title">Etat:</label>
          <input type="radio" name="state" value="1" class="w-10" required disabled>Plein
        <input type="radio" name="state"  value="0" class="w-10" required disabled>Vide
        <br>

        @if ($errors->has("state"))
        <p class="text-red-500">{{$errors->first('state')}}</p>
    @endif
        </div>
        <div class="text-start mt-2">
            <label for="" class="text-start">type:</label>
            <select name="type" id="" class="w-full p-2 font-bold" required>
                <option value="accessoire">Accessoire</option>
            </select>

            @if ($errors->has("type"))
                <p class="text-red-500">{{$errors->first('type')}}</p>
            @endif
        </div>
        <br>
        <div class="w-full flex justify-end">
            <button class="text-white font-bold bg-blue-400 p-2" type="submit">Enregistrer </button>
        </div>
    </form>
</center>
@endsection