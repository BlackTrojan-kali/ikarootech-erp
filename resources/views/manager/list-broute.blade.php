@extends('Layouts.ManagerLayout')
@section('content')
    <center>
        <h1 class="text-2xl font-bold ">Liste des bordereaux de route</h1>
        <table id="table-broute" class=" scroll mt-10 w-full border-2 border-gray-400 border-collapse-0">
            <thead class="bg-gray-500 text-white p-2 border-collapse-0">
                <tr>
                    <td>N/S</td>
                    <td>Nom Chauffeur</td>
                    <td>Ville depart</td>
                    <td>Ville arrivee</td>
                    <td>Date depart</td>
                    <td>Date Retour</td>
                    <td>Aide chauffeur</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($broutes as $broute)
                    <tr id="{{ $broute->id }}">
                        <td>{{ $broute->id }}</td>
                        <td>{{ $broute->nom_chauffeur }}</td>
                        <td>{{ $broute->depart }}</td>
                        <td>{{ $broute->arrivee }}</td>
                        <td>{{ $broute->date_depart }}</td>
                        <td>{{ $broute->date_arrivee }}</td>
                        <td>{{ $broute->aide_chauffeur }}</td>
                        <td><a href="{{ route('gen-broute-2', ['id' => $broute->id]) }}"><i
                                    class="text-teal-900 cursor-pointer fa-solid fa-download " title="generer le pdf"></i></a>

                            <?php
                            //calculate date time
                            $now = now()->format('Y-m-d H:i:s');
                            $date2 = $broute->created_at;
                            $interval = $date2->diff($now);
                            $days = $interval->format('%a');
                            ?>
                            @if ($days <= 3)
                                <i class="text-red-500 delete cursor-pointer fa-solid fa-trash"
                                    title="supprimer l'entree"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
        <br>

    </center>

    <script type="module">
        $(function() {
            $("#table-broute").on("click", ".delete", function() {
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
                            url: "/manager/broute-list-del/" + id,
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
