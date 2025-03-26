@extends('Layouts.controllerLayout')
@section('content')

    <center>

        <h1>HISTORIQUES DES RELEVES</h1>

        <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="bg-gray-500 text-white p-2 border-collapse-0">
                <tr>
                    <td>No</td>
                    <td>Citerne</td>
                    <td>Stock Theorique</td>
                    <td>Stock Releve</td>
                    <td>ecart</td>
                    <td>Date de Creation</td>
                    <td>Date de Modification</td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($depotages->first()))
                    @foreach ($depotages as $move)
                        <tr id="{{ $move->id }}" class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                            <td>{{ $move->id }}</td>
                            <td>
                                {{ $move->citerne }}
                            </td>
                            <td>
                                {{ $move->stock_theo }}</td>
                            <td>
                                {{ $move->stock_rel }}</td>
                            <td>{{ $move->stock_rel - $move->stock_theo }}</td>
                            <td>{{ $move->created_at }}</td>
                            <td>{{ $move->updated_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <p> aucun resultat</p>
                @endif
            </tbody>
        </table>

    </center>

    <script>
        $(function() {
            $('table').DataTable();
            //evement sur les historiques
            /*$(".delete").on("click",function(){
                id = $(this).parent().parent().attr("id");
           
                var token = $("meta[name='csrf-token']").attr("content");
                Swal.fire({
          title: "Etes vous sures ? cette operation est irreversible",
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: "Supprimer",
          denyButtonText: `Annuler`
        }).then((result) => {
          //Read more about isConfirmed, isDenied below 
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
            })*/
        })
    </script>
@endsection
