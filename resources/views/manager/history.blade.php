 @extends("Layouts.ManagerLayout")
 @section("content")
 <div class="mx-10">
     <h1 class="text-2xl  font-bold ml-12">Historique des Mouvements </h1>
     <div class="w-full   border-2 border-gray-300 rounded-md">
        <div class="w-full  bg-gray-600 text-white py-2 px-4 flex justify-between">
            Filtre
            <span class="show-filter font-bold text-3xl cursor-pointer">-</span>
        </div>
        <div class="w-full p-3 filter-content">
            <form action="{{route("manager-filtered-history")}}" method="POST">
                @csrf
            <div class="flex gap-5">
                <div class="champs">
                    <label for="">De</label><br>
                    <input name="fromdate" type="date" id="">
                    @if($errors->has("fromdate"))
                        <p class="text-red-500">{{$errors->first("fromdate")}}</p>
                    @endif
                </div>
                <div class="champs">
                    <label for="">Jusqu'a</label><br>
                    <input name="todate" type="date" id="date"
                     required>
                     @if($errors->has("todate"))
                         <p class="text-red-500">{{$errors->first("todate")}}</p>
                     @endif
                </div>
            </div>
            <div class="flex mt-2">
                <div >
                    <label for="">Article</label>
                <select name="type" class="w-full h-10" id="">
                    <option value="bouteilles-pleines">Bouteilles pleines</option>
                    <option value="bouteilles-vides">Bouteilles vides</option>
                    @foreach ($accessories as $accessory )
                        
                    <option value="{{$accessory->title}}">{{$accessory->title}}</option>
                    @endforeach
                </select>

                @if($errors->has("type"))
                <p class="text-red-500">{{$errors->first("type")}}</p>
            @endif
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-400 text-white p-2">Appliquer</button>
        </form>
        </div>
     </div>
     <br>
 </div>
     <h1 class="font-bold text-2xl">Historique des entrees</h1>
     <br>
     <div>
         <table class="history scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="p-2 bg-gray-500 text-white">
                <tr>
                    <td>Date</td>
                    <td>identifiant</td>
                    <td>origin</td>
                    <td>article</td>
                    <td>entree</td>
                    <td>qte</td>
                    <td>bordereau</td>
                    <td>stock</td>
                    <td>state</td>
                    <td>commentaire</td>
                    <td>action</td>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($allMoves as $move )
    
                    <tr id="{{$move->id}}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                        <td>{{$move->created_at}}</td>
                        <td>{{$move->id}}</td>
                        <td>{{$move->origin}}</td>
                        <td>{{$move->fromArticle->type}} - {{$move->fromArticle->weight}} KG </td>
                        <td>{{$move->entree}}</td>
                        <td>{{$move->qty}}</td>
                        <td>{{$move->bordereau}}</td>
                        <td>{{$move->stock}}</td>
                        <td>{{$move->fromArticle->state? "plein":"vide"}}</td>
                        <td>{{$move->label}} </td>
                        <td><span class="text-red-500 delete"> <i class="fa-solid fa-trash"></i></span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
     </div>
     <br>
     <h1 class="font-bold text-2xl">Historique des Sortie</h1>
     <br>
     <div>
         <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="p-2 bg-gray-500 text-white">
                <tr>
                    <td>Date</td>
                    <td>identifiant</td>
                    <td>origin</td>
                    <td>article</td>
                    <td>sortie</td>
                    <td>qte</td>
                    <td>Bordereau</td>
                    <td>stock</td>
                    <td>state</td>
                    <td>commentaire</td>
                    <td>action</td>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($allMovesOut as $move )
                    <tr  id="{{$move->id}}" class="hover:text-white move-row hover:bg-blue-400 hover:cursor-pointer">
                        <td>{{$move->created_at}}</td>
                        <td>{{$move->id}}</td>
                        <td>{{$move->origin}}</td>
                        <td>{{$move->fromArticle->type}} - {{$move->fromArticle->weight}} KG </td>
                        <td>{{$move->sortie}}</td>
                        <td>{{$move->qty}}</td>
                        <td>{{$move->bordereau}}</td>
                        <td>{{$move->stock}}</td>
                        <td>{{$move->fromArticle->state? "plein":"vide"}}</td>
                        <td>{{$move->label}} </td>
                        <td><span class="text-red-500 delete"> supprimer</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
     </div>
    </div>
     <script>
        $( function () {
    $('table').DataTable();
    //evement sur les historiques
$(".show-filter").on("click",function(){
    $(".filter-content").toggleClass("hidden")
})
    $(".delete").on("click",function(){
        id = $(this).parent().parent().attr("id");
   
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
  title: "Etes vous sures ? cette operation est irreversible",
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: "Supprimer",
  denyButtonText: `Annuler`
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
        $.ajax({
            url:"/manager/DeleteMove/"+id,
            dataType:"json",
            data: {
                "id": id,
                "_token": token,
            },
            method:"DELETE",
            success:function(res){
                toastr.warning(res.message)
                $("#"+id).load(location.href+ " #"+id)
            },
        }) } else if (result.isDenied) {
    Swal.fire("Changement non enregistre", "", "info");
  }
})
    })
} );
     </script>
 @endsection