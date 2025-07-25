@extends("Layouts.producerLayout")
@section("content")
<center>
    <h1 class="font-bold my-4">Depotage DE GPL VRAC</h1>
    <div>
        <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="text-white font-bold bg-slate-600 p-2">
                <tr>
                    <td>S\L</td>
                    <td>Citerne_fixe</td>
                    <td>Citerne_mobile</td>
                    <td>Qte</td>
                    <td>matricule</td>
                    <td>date</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($depotages as $reception )
                    <tr id={{ $reception->id }} class="hover:bg-blue-400 hover:text-white cursor-pointer">
                        <td>{{$reception->id}}</td>
                        <td>{{$reception->citerne_mobile->name}} ({{$reception->citerne_mobile->type}})</td>
                        <td>{{$reception->citerne_fixe->name}} ({{$reception->citerne_fixe->type}})</td>
                        <td>{{$reception->qty}}</td>
                        <td>{{$reception->matricule}}</td>
                        <td>{{$reception->created_at}}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</center>
<script>
$( function () {
    $('table').DataTable();
    //evement sur les historiques
    //evement sur les historiques
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
            url:"/producer/DeleteRec/"+id,
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
})</script>
@endsection