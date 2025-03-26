@extends("Layouts.appLayout")
@section("content")
<?php
$name = "stargaz"
?>
<center class="w-full p-4">
    <h1 class="mb-3 text-xl font-bold">Enregistrer une nouvelle famille produit</h1>
    <form action="{{route("insertFamily")}}" method="POST" class="p-4 border border-blue-400 rounded-lg w-5/12">
        @csrf
      
        <div class="champs">
            <label for="name">Nom:</label>
            <input type="text" name="name" required>
            @if ($errors->has("name"))
                <p class="text-red-500">{{$errors->first('name')}}</p>
            @endif
        </div>
        <br>
        <div class="w-full flex justify-end">
            <button class="text-white font-bold bg-blue-400 p-2" type="submit">Enregistrer </button>
        </div>
    </form>
</center>
@endsection