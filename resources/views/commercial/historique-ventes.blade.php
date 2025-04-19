@extends('Layouts.comLayout')
@section('content')
    <div>

        <h1 class="p-2 mt-5 font-bold text-2xl">Historique des {{ strtoupper($type) }}S
        </h1>
        <!-- Neo  invoices -->
        <table id="table-invoices" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 ">
            <thead class="p-3 bg-gray-500 text-white">

                <tr>
                    <th>
                        nom Client
                    </th>
                    <th>
                        total facture
                    </th>
                    <th>
                        encaissé
                    </th>
                    <th>
                        ecart
                    </th>
                    <th>
                        date
                    </th>
                    <th>actions</td>
                </tr>
     
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <?php $prods = json_decode($sale->articles, true);
                    
                    ?>
                    <tr id="{{ $sale->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                      
                        <td  class="border  border-black">
                            {{ $sale->client->nom . ' ' . $sale->client->prenom }}</td>

                      
                        <td   class="border  border-black">
                            {{ $sale->total_price }}
                        </td>
                        <td    class="border  border-black">
                            {{ $sale->recieved }}
                        </td>
                        <td    class="border  border-black">
                            <?php $ecart = $sale->recieved - $sale->total_price; ?>
                            @if ($ecart >= 0)
                                <p class="text-blue-400">{{ $ecart }}</p>
                            @else
                                <p class="text-red-500">{{ $ecart }}</p>
                            @endif
                        </td>
                        <td   class="border  border-black">{{ $sale->created_at }}</td>
                        <td   class="border  border-black"><a href="{{ route('printNeoInvoice', ['id' => $sale->id]) }}"><i
                                    class="text-teal-900 fa-solid fa-download" title="generer pdf"></i></a>

                            <a href="{{ route('modifyInvoice', $sale->id) }}"><i
                                    class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i></a>

                            <?php
                            //calculate date time
                            $now = now()->format('Y-m-d H:i:s');
                            $date2 = $sale->created_at;
                            $interval = $date2->diff($now);
                            $days = $interval->format('%a');
                            ?>
                            @if ($days <= 1000)
                                <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                            @endif
                            <a href="{{ route("vente_versement",["id"=>$sale->id]) }}" class="text-green-700"><i class="fa-solid fa-link"></i></a>
                            <a href="{{ route("vente_versement_detach",["id"=>$sale->id]) }}" class="text-yellow-700">detacher</a>
                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>




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
                        <td class="border  border-black"><a href="{{ route('printInvoice', ['id' => $vente->id]) }}"><i
                                    class="text-teal-900 fa-solid fa-download" title="generer pdf"></i></a>
                            <a href="{{ route('modifySale', $vente->id) }}"><i
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

            $("#table-invoices").on("click", ".delete", function() {
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
                            url: "/commercial/deleteInvoice/" + id,
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
