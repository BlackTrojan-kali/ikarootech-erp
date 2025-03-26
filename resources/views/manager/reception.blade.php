@extends('Layouts.ManagerLayout')
@section('content')
    <center>
        <div>
            <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
                <thead class="text-white font-bold bg-slate-600 p-2">
                    <tr>
                        <td>S\L</td>
                        <td>Citerne</td>
                        <td>Qte</td>
                        <td>Reception</td>
                        <td>Matricule Veh</td>
                        <td>Borde. Livraison</td>
                        <td>date</td>
                        <td>action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receptions as $reception)
                        <tr id={{ $reception->id }} class="hover:bg-blue-400 hover:text-white cursor-pointer">
                            <td>{{ $reception->id }}</td>
                            <td>{{ $reception->citerne->name }} ({{ $reception->citerne->type }})</td>
                            <td>{{ $reception->qty }}</td>
                            <td>{{ $reception->receiver }}</td>
                            <td>{{ $reception->matricule }}</td>
                            <td>{{ $reception->livraison }}</td>
                            <td>{{ $reception->created_at }}</td>
                            <td><span class="text-blue-500" title="modifier"> <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="text-red-500 delete" title="supprimer"> <i
                                            class="fa-solid fa-trash"></i></span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </center>
    <script>
        $(function() {
            $('table').DataTable();
            //evement sur les historiques
            $(".delete").on("click", function() {
                id = $(this).parent().parent().parent().attr("id");
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
                            url: "/manager/DeleteRec/" + id,
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
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                })
            })
        })
    </script>
@endsection
