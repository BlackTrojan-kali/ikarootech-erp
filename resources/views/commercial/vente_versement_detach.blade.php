@extends('Layouts.comLayout')
@section('content')
    <h1 class="text-2xl  font-bold ">Versements a associer </h1>
    <br>
    <div>
        <table class="history scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="p-2 bg-gray-500 text-white">
                <tr>
                    <td>Bank</td>
                    <td>Montant_gpl</td>
                    <td>Montant_consigne</td>
                    <td>Commentaire</td>
                    <td>bordereau</td>
                    <td>Date</td>
                    <td>Action</td>

                </tr>
            </thead>
            <tbody>
                @foreach ($versements as $verse)
                  <tr>
                    <td>{{$verse->bank}}</td>
                    <td>{{$verse->montant_gpl}}</td>
                    <td>{{$verse->montant_consigne}}</td>
                    <td>{{$verse->commentaire}}</td>
                    <td>{{$verse->bordereau}}</td>
                    <td>{{$verse->created_at}}</td>
                    <td>
                        @if($sale->id_versement != $verse->id)
                        <a href="{{ route("versement_vente_dissoc",["id_vente"=>$sale->id,"id_versement"=>$verse->id]) }}"> Dissocier</a>
                        @endif
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
 
    </div>
    <script>
        $(function() {
            $('table').DataTable();
            //evement sur les historiques
            $(".show-filter").on("click", function() {
                $(".filter-content").toggleClass("hidden")
            })
            $("#table-sales").on("click", "delete", function() {
                id = $(this).parent().parent().attr("id");

                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: "/manager/DeleteMove/" + id,
                    dataType: "json",
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    method: "DELETE",
                    success: function(res) {
                        toastr.warning(res.message)
                        $("#" + id).load(location.href + " #" + id)
                    },
                })
            })
        });
    </script>
@endsection
