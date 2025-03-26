@extends("Layouts.ManagerLayout")
@section("content")
<center>
    <h1 class="font-bold text-2xl">Nouvelle {{$action == "entry" ? "entree":"sortie"}} d'Accessoires</h1>
    <br>
    <form action="{{route("saveBottleMove",$action)}}" method="POST" class="p-10 w-5/12 border-2 rounded-md border-blue-400">
    @csrf
    <div class="champs">
        <label for="">Provenance :</label>
        <input type="text" name="origin">
        @if ($errors->has("origin"))
            <p class="text-red-500">{{$errors->first("origin")}}</p>
        @endif
    </div>

    <div class="text-start my-2">
        <label for="">Poids :</label>
        <input type="radio" value="6" name="weight"> 6Kg
        <input type="radio" value="12.5" name="weight"> 12.5Kg
        <input type="radio" value="50" name="weight"> 50Kg
       

        @if ($errors->has("weight"))
        <br>    <p class="text-red-500">{{$errors->first("weight")}}</p>
        @endif
    </div>
    <div class="champs ">
        <label for="">Quantite</label>
        <input type="number" name="qty">
        @if ($errors->has("qty"))
            <p class="text-red-500">{{$errors->first("qty")}}</p>
        @endif
    </div>
    <div class="text-start my-2">
        <label for="">Etat :</label>
        <input type="radio" value="0" name="state"> Vide
        <input type="radio" value="1" name="state"> Pleine 

        @if ($errors->has("state"))
        <br>
            <p class="text-red-500">{{$errors->first("state")}}</p>
        @endif
    </div>
    <div class="flex w-full justify-end">
        <button type="submit" class="text-white bg-blue-400 font-bold p-3">Enregistrer</button>
    </div>
    </form>
</center>
@endsection