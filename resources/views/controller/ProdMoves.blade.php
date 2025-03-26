@extends('Layouts.controllerLayout')
@section('content')
    <center>
        <h1 class="text-2xl font-bold">historique des productions</h1>
        <div>
            <table class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
                <thead class="text-white font-bold bg-slate-600 p-2">
                    <tr>
                        <td>S\L</td>
                        <td>Citerne</td>
                        <td>type</td>
                        <td>Qte</td>
                        <td>Borde. Prod</td>
                        <td>date</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr id={{ $data->id }} class="hover:bg-blue-400 hover:text-white cursor-pointer">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->citerne->name }} ({{ $data->citerne->type }})</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->qty }}</td>
                            <td>{{ $data->bordereau }}</td>
                            <td>{{ $data->created_at }}</td>
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
