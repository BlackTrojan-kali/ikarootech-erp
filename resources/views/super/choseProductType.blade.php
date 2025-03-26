@extends("Layouts.appLayout")
@section("content")
<div class="p-5">
    <center class="flex justify-center gap-20">
        <button class="font-bold bg-blue-400 text-white p-4 text-2xl rounded-md hover:scale-90 transition-all duration-100"><a href="{{route("addArticle")}}">Bouteilles de Gaz</a></button>
        <button class="font-bold border-2 border-black text-black p-4 text-2xl rounded-md hover:scale-90 transition-all duration-100"><a href="{{route("addAccessory")}}">Accessoire</a></button>
    </center>
</div>
@endsection