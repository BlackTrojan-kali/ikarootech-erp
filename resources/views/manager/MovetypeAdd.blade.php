@extends("Layouts.ManagerLayout")
@section("content")
<div class="p-5">
    <center>
        <h1 class="font-bold text-2xl mb-5">Enregistrer une 
            @if ($action == "entry")
                Entree
                @else
                Sortie
            @endif
        </h1>
        <div class="flex justify-center gap-20">
            
        <button class="font-bold bg-blue-400 text-white p-4 text-2xl rounded-md hover:scale-90 transition-all duration-100"><a href="{{route("registerMoveForm",["action"=>$action,"type"=>"bouteille-gaz"])}}">Bouteille de Gaz</a></button>
        <button class="font-bold border-2 border-black text-black p-4 text-2xl rounded-md hover:scale-90 transition-all duration-100"><a href="{{route("registerMoveForm",["action"=>$action,"type"=>"accessoire"])}}">Accessiores</a></button>
            
        </div>
    </center>
</div>
@endsection