@extends("Layouts.comLayout")
@section("content")

    <center>
    <div class=" bg-white top-1/3 left-1/4 w-2/3 p-2 border rounded-md  border-black modal-list mt-8">
        <div class="w-full justify-between">
            <button class="primary text-white p-2 rounded-md" id="associate">associer</button>
            <a href="{{ route("showVentes","versements") }}" class="secondary text-white p-2 rounded-md" id="close">Fermer</a>
        </div>
        <form id="associationForm" action="{{ route("assoc_versement_vente") }}" method="POST">
        @csrf
            <table id="ventesTable overflow-x-scrolls">
            <thead>
                <tr>
                    <td>Client</td>
                    <td>Total Facture</td>
                    <td>Mode de Paiment</td>
                    <td>type</td>
                    <td>date</td>
                    <th><input type="checkbox" id="all"/></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice )
                    <tr>

                    <td>{{ $invoice->client->nom." ".$invoice->client->prenom }}</td>
                    <td>{{ $invoice->total_price  }}</td>
                    <td>{{ $invoice->currency }}</td>
                    <td>{{$invoice->type}}</td>
                    <td>{{$invoice->created_at}}</td>
                    <td>
                        <input type="checkbox" class="vente-checkbox" value="{{ $invoice->id }}"></td>
                   
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    </div>
    </center>
    <script type="module">
        $(function() {
            let id_versement = {{ $idVer }};
            let oTable = $('#ventesTable').dataTable();
            $('#all').click(function (e) {
            $('#ventesTable tbody :checkbox').prop('checked', $(this).is(':checked'));
            e.stopImmediatePropagation();
            });

            $('#associate').click(function() {
            var selectedVentes = [];
            $('.vente-checkbox:checked').each(function() {
                selectedVentes.push($(this).val());
            });
            if (selectedVentes.length > 0) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'ventes',
                    value: selectedVentes.join(',')
                }).appendTo('#associationForm');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'versement',
                    value: id_versement
                }).appendTo('#associationForm');

                $('#associationForm').submit();
            } else {
                alert('Veuillez sélectionner au moins une vente.');
            }
        });
//modal functions
$("#close").on("click",function(){
    $(".modal-list").addClass("hidden");
})
//tables functions delete edit
            $("#table1").on("click", ".delete", function() {
                var id = $(this).parent().parent().attr("id");
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
                            url: "/commercial/deleteVersemment/" + id,
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
                            error: function(xhr, status, err) {
                                console.log(xhr)
                                console.log(err)
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                })
            })
            $("#table2").on("click", ".delete", function() {
                var id = $(this).parent().parent().attr("id");
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
                            url: "/commercial/deleteVersemment/" + id,
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
                            error: function(xhr, status, err) {
                                console.log(xhr)
                                console.log(err)
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                })
            })
            $("#table3").on("click", ".delete", function() {
                var id = $(this).parent().parent().attr("id");
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
                            url: "/commercial/deleteVersemment/" + id,
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
                            error: function(xhr, status, err) {
                                console.log(xhr)
                                console.log(err)
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                })
            })
        })
    </script>
@endsection