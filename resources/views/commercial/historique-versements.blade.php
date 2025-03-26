@extends('Layouts.comLayout')
@section('content')
    <center>
        <h1 class="p-2 mt-5 font-bold text-2xl">Historique des Versements

        </h1>
        <div class=" flex w-full gap-3">
            <!-- The whole future lies in uncertainty: live immediately. - Seneca -->

            <table id="table1" class="history scroll mt-10 w-1/2 border-2 border-collapse border-gray-400 text-center ">
                <thead class="p-3 bg-gray-500 text-white">
                    <td colspan="7" class="text-center">
                        {{ env('COMPANIE_BANK_1') }}
                    </td>
                    <tr>
                        <td>
                            date
                        </td>
                        <td>
                            GPL
                        </td>
                        <td>
                            Consigne
                        </td>
                        <td>
                            Montant Versee
                        </td>
                        <td>
                            Numerode bordereau
                        </td>
                        <td>commentaire</td>
                        <td>action</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ventes as $vente)
                        <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                            <td>{{ $vente->created_at }}</td>
                            <td>
                                {{ $vente->montant_gpl }}
                            </td>
                            <td>
                                {{ $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->montant_gpl + $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->bordereau }}
                            </td>
                            <td> {{ $vente->commentaire }}</td>
                            <td>
                                <a href="{{ route('modifyVersement', $vente->id) }}"> <i
                                        class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i>
                                </a>
                                <?php
                                //calculate date time
                                $now = now()->format('Y-m-d H:i:s');
                                $date2 = $vente->created_at;
                                $interval = $date2->diff($now);
                                $days = $interval->format('%a');
                                ?>
                                @if ($days <= 3)
                                    <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table id="table2" class="history scroll mt-10 w-1/2 border-2 border-collapse border-gray-400 text-center ">
                <thead class="p-3 bg-gray-500 text-white">
                    <td colspan="7" class="text-center">
                        {{ env('COMPANIE_BANK_2') }}
                    </td>
                    <tr>
                        <td>date</td>
                        <td>
                            GPL
                        </td>
                        <td>
                            Consigne

                        </td>
                        <td>
                            Montant Versee
                        </td>

                        <td>
                            Numerode bordereau
                        </td>
                        <td>
                            commentaire
                        </td>
                        <td>action</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ventes2 as $vente)
                        <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                            <td>{{ $vente->created_at }}</td>
                            <td>
                                {{ $vente->montant_gpl }}
                            </td>
                            <td>
                                {{ $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->montant_gpl + $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->bordereau }}
                            </td>
                            <td>
                                {{ $vente->commentaire }}
                            </td>
                            <td>
                                <a href="{{ route('modifyVersement', $vente->id) }}"> <i
                                        class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i></a>
                                <?php
                                //calculate date time
                                $now = now()->format('Y-m-d H:i:s');
                                $date2 = $vente->created_at;
                                $interval = $date2->diff($now);
                                $days = $interval->format('%a');
                                ?>
                                @if ($days <= 3)
                                    <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table id="table3" class="history scroll mt-10 w-1/2 border-2 border-collapse border-gray-400 text-center ">
                <thead class="p-3 bg-gray-500 text-white">
                    <td colspan="7" class="text-center">
                        CAISSE
                    </td>
                    <tr>
                        <td>date</td>
                        <td>
                            GPL
                        </td>
                        <td>
                            Consigne

                        </td>
                        <td>
                            Montant Versee
                        </td>

                        <td>
                            Numerode bordereau
                        </td>
                        <td>
                            commentaire
                        </td>
                        <td>action</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ventes3 as $vente)
                        <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                            <td>{{ $vente->created_at }}</td>
                            <td>
                                {{ $vente->montant_gpl }}
                            </td>
                            <td>
                                {{ $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->montant_gpl + $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->bordereau }}
                            </td>
                            <td>
                                {{ $vente->commentaire }}
                            </td>
                            <td>
                                <a href="{{ route('modifyVersement', $vente->id) }}"> <i
                                        class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i></a>
                                <?php
                                //calculate date time
                                $now = now()->format('Y-m-d H:i:s');
                                $date2 = $vente->created_at;
                                $interval = $date2->diff($now);
                                $days = $interval->format('%a');
                                ?>
                                @if ($days <= 3)
                                    <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>

        </div>
    </center>
    <script type="module">
        $(function() {
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
