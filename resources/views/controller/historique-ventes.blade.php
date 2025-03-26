@extends('Layouts.controllerLayout')
@section('content')
    <div>

        <h1 class="p-2 mt-5 font-bold text-2xl">Historique des {{ strtoupper($type) }}S
        </h1>
        <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
        <table id="table-ventes" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 ">
            <thead class="p-3 bg-gray-500 text-white">
                <tr>
                    <th>
                        nom Client
                    </th>
                    <th colspan="6">
                        qtes vendus
                    </th>
                    <th>
                        prix total
                    </th>
                    <th>
                        date
                    </th>
                    <th>actions</td>
                </tr>
                <tr class="border  border-black">
                    <th class="border  border-black">/</th>
                    <th class="border  border-black" colspan="2">50 KG</th>
                    <th class="border  border-black" colspan="2">12.5 KG</th>
                    <th class="border  border-black" colspan="2">6 KG</th>
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">/</th>
                </tr>
                <tr class="border  border-black">
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">Prix U</th>
                    <th class="border  border-black">Qte</th>
                    <th class="border  border-black">Prix U</th>
                    <th class="border  border-black">Qte</th>
                    <th class="border  border-black">Prix U</th>
                    <th class="border  border-black">Qte</th>
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">/</th>
                    <th class="border  border-black">/</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($ventes as $vente)
                    <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                        <td class="border  border-black">{{ $vente->customer }}</td>
                        <td class="border  border-black">{{ $vente->prix_50 }}</td>
                        <td class="border  border-black">{{ $vente->qty_50 }}</td>
                        <td class="border  border-black">{{ $vente->prix_12 }}</td>
                        <td class="border  border-black">{{ $vente->qty_12 }}</td>
                        <td class="border  border-black">{{ $vente->prix_6 }}</td>
                        <td class="border  border-black">{{ $vente->qty_6 }}</td>
                        <td class="border  border-black">
                            {{ $vente->prix_6 * $vente->qty_6 + $vente->prix_12 * $vente->qty_12 + $vente->prix_50 * $vente->qty_50 }}
                        </td>
                        <td class="border  border-black">{{ $vente->created_at }}</td>
                        <td class="border  border-black"><a
                                href="{{ route('printInvoiceController', ['id' => $vente->id]) }}"><i
                                    class="text-teal-900 fa-solid fa-download" title="generer pdf"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script type="module">
        $(function() {
            $("#table-ventes").on("click", ".delete", function() {
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
                            url: "/commercial/delventes/" + id,
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
