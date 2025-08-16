@extends('Layouts.comLayout')
@section('content')
    <center>
        <h1 class="p-2 mt-5 font-bold text-2xl">Historique des Versements</h1>
        <div class="flex w-full gap-3">
            {{-- Table 1 --}}
            <div class="w-1/2 overflow-y-auto max-h-[500px]"> {{-- Ajouté max-h et overflow-y-auto ici --}}
                <table id="table1" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 text-center ">
                    <thead class="p-3 bg-gray-500 text-white sticky top-0 z-10"> {{-- Ajouté sticky top-0 z-10 pour l'en-tête --}}
                        <td colspan="7" class="text-center">
                            {{ env('COMPANIE_BANK_1') }}
                        </td>
                        <tr>
                            <td>date</td>
                            <td>GPL</td>
                            <td>Consigne</td>
                            <td>Montant Versee</td>
                            <td>Numerode bordereau</td>
                            <td>commentaire</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventes as $vente)
                            <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                                <td>{{ $vente->created_at }}</td>
                                <td>{{ $vente->montant_gpl }}</td>
                                <td>{{ $vente->montant_consigne }}</td>
                                <td>{{ $vente->montant_gpl + $vente->montant_consigne }}</td>
                                <td>{{ $vente->bordereau }}</td>
                                <td>{{ $vente->commentaire }}</td>
                                <td>
                                    <a href="{{ route('modifyVersement', $vente->id) }}">
                                        <i class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i>
                                    </a>
                                    @php
                                        $now = now();
                                        $date2 = $vente->created_at;
                                        $interval = $date2->diff($now);
                                        $days = $interval->days;
                                    @endphp
                                    @if ($days <= 3)
                                        <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                                    @endif
                                    <i class="fa-solid fa-link link-to-sales" title="lier a des ventes"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Table 2 --}}
            <div class="w-1/2 overflow-y-auto max-h-[500px]"> {{-- Ajouté max-h et overflow-y-auto ici --}}
                <table id="table2" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 text-center ">
                    <thead class="p-3 bg-gray-500 text-white sticky top-0 z-10"> {{-- Ajouté sticky top-0 z-10 pour l'en-tête --}}
                        <td colspan="7" class="text-center">
                            {{ env('COMPANIE_BANK_2') }}
                        </td>
                        <tr>
                            <td>date</td>
                            <td>GPL</td>
                            <td>Consigne</td>
                            <td>Montant Versee</td>
                            <td>Numerode bordereau</td>
                            <td>commentaire</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventes2 as $vente)
                            <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                                <td>{{ $vente->created_at }}</td>
                                <td>{{ $vente->montant_gpl }}</td>
                                <td>{{ $vente->montant_consigne }}</td>
                                <td>{{ $vente->montant_gpl + $vente->montant_consigne }}</td>
                                <td>{{ $vente->bordereau }}</td>
                                <td>{{ $vente->commentaire }}</td>
                                <td>
                                    <a href="{{ route('modifyVersement', $vente->id) }}">
                                        <i class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i>
                                    </a>
                                    @php
                                        $now = now();
                                        $date2 = $vente->created_at;
                                        $interval = $date2->diff($now);
                                        $days = $interval->days;
                                    @endphp
                                    @if ($days <= 3)
                                        <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                                    @endif
                                    <i class="fa-solid fa-link link-to-sales" title="lier a des ventes"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Table 3 --}}
            <div class="w-1/2 overflow-y-auto max-h-[500px]"> {{-- Ajouté max-h et overflow-y-auto ici --}}
                <table id="table3" class="history scroll mt-10 w-full border-2 border-collapse border-gray-400 text-center ">
                    <thead class="p-3 bg-gray-500 text-white sticky top-0 z-10"> {{-- Ajouté sticky top-0 z-10 pour l'en-tête --}}
                        <td colspan="7" class="text-center">
                            CAISSE
                        </td>
                        <tr>
                            <td>date</td>
                            <td>GPL</td>
                            <td>Consigne</td>
                            <td>Montant Versee</td>
                            <td>Numerode bordereau</td>
                            <td>commentaire</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventes3 as $vente)
                            <tr id="{{ $vente->id }}" class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                                <td>{{ $vente->created_at }}</td>
                                <td>{{ $vente->montant_gpl }}</td>
                                <td>{{ $vente->montant_consigne }}</td>
                                <td>{{ $vente->montant_gpl + $vente->montant_consigne }}</td>
                                <td>{{ $vente->bordereau }}</td>
                                <td>{{ $vente->commentaire }}</td>
                                <td>
                                    <a href="{{ route('modifyVersement', $vente->id) }}">
                                        <i class="text-blue-500 fa-solid fa-pen-to-square" title="modifier"></i>
                                    </a>
                                    @php
                                        $now = now();
                                        $date2 = $vente->created_at;
                                        $interval = $date2->diff($now);
                                        $days = $interval->days;
                                    @endphp
                                    @if ($days <= 3)
                                        <i class="text-red-500 delete fa-solid fa-trash" title="supprimer"></i>
                                    @endif
                                    <i class="fa-solid fa-link link-to-sales" title="lier a des ventes"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </center>

    <center>
        {{-- MODALE POUR LA LISTE DES VENTES À ASSOCIER --}}
        <div id="ventes-list-modal" class="modal-overlay hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50">
            <div class="modal-content bg-white p-6 rounded-md border border-black shadow-lg w-full max-w-4xl mx-auto my-8 overflow-y-auto max-h-[90vh]">
                {{-- Modifié ici pour aligner "Fermer" à gauche et "Associer" à droite --}}
                <div class="flex justify-between items-center mb-4">
                    <button type="button" class="secondary text-white p-2 rounded-md close-modal">Fermer</button>
                    <button class="primary text-white p-2 rounded-md" id="associate-button">Associer</button>
                </div>

                <h2 class="text-xl font-bold text-center mb-4">Sélectionner les ventes à associer</h2>

                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <label for="all-checkbox" class="mr-2 text-gray-700">Sélectionner tout</label>
                        <input type="checkbox" id="all-checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                    </div>
                </div>

                <form id="associationForm" action="{{ route("assoc_versement_vente") }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table id="ventesTable" class="min-w-full leading-normal border border-black rounded-md">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-black text-left text-xs font-semibold uppercase tracking-wider">Client</th>
                                    <th class="px-5 py-3 border-b-2 border-black text-left text-xs font-semibold uppercase tracking-wider">Total Facture</th>
                                    <th class="px-5 py-3 border-b-2 border-black text-left text-xs font-semibold uppercase tracking-wider">Mode de Paiement</th>
                                    <th class="px-5 py-3 border-b-2 border-black text-left text-xs font-semibold uppercase tracking-wider">Type</th>
                                    <th class="px-5 py-3 border-b-2 border-black text-left text-xs font-semibold uppercase tracking-wider">Date</th>
                                    <th class="px-5 py-3 border-b-2 border-black text-left text-xs font-semibold uppercase tracking-wider">Sélection</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice )
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $invoice->client->nom." ".$invoice->client->prenom }}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $invoice->total_price }}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $invoice->currency }}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{$invoice->type}}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{$invoice->created_at->format('d/m/Y H:i')}}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                            <input type="checkbox" class="vente-checkbox form-checkbox h-4 w-4 text-blue-600 rounded" value="{{ $invoice->id }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-500">Aucune vente disponible pour l'association.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </center>

    <script type="module">
        $(function() {
            let id_versement = 0;

            // Fonction pour initialiser une table DataTables si elle ne l'est pas déjà
            const initializeDataTable = (tableId) => {
                if ($.fn.DataTable.isDataTable(`#${tableId}`)) {
                    // Si la table est déjà une DataTable, la détruire avant de la réinitialiser
                    $(`#${tableId}`).DataTable().destroy();
                }
                $(`#${tableId}`).DataTable({
                    "paging": false,
                    "searching": false,
                    "info": false,
                    "order": [] // Désactive le tri par défaut
                });
            };

            // Initialisation de DataTables pour les tables d'historique
            initializeDataTable("table1");
            initializeDataTable("table2");
            initializeDataTable("table3");

            // Initialisation de DataTables pour la table des ventes dans la modale
            initializeDataTable("ventesTable");


            // Gérer l'ouverture de la modale d'association pour toutes les tables d'historique
            // Utilisation d'une classe pour les icônes de lien pour éviter les duplications d'ID
            $('#table1, #table2, #table3').on("click", ".link-to-sales", function() {
                id_versement = $(this).closest('tr').attr("id");
                $("#ventes-list-modal").removeClass("hidden");
            });

            // Gérer la sélection/désélection de toutes les cases à cocher dans la modale
            $('#all-checkbox').click(function (e) {
                $('#ventesTable tbody .vente-checkbox').prop('checked', $(this).is(':checked'));
                e.stopImmediatePropagation(); // Empêche la propagation du clic, utile si cet élément est imbriqué
            });

            // Gérer le clic sur le bouton "Associer" dans la modale
            $('#associate-button').click(function() {
                var selectedVentes = [];
                $('.vente-checkbox:checked').each(function() {
                    selectedVentes.push($(this).val());
                });

                if (selectedVentes.length > 0) {
                    // Vérifier si les inputs cachés existent déjà, sinon les créer
                    let ventesInput = $('#associationForm input[name="ventes"]');
                    let versementInput = $('#associationForm input[name="versement"]');

                    if (ventesInput.length === 0) {
                        ventesInput = $('<input>').attr({ type: 'hidden', name: 'ventes' }).appendTo('#associationForm');
                    }
                    if (versementInput.length === 0) {
                        versementInput = $('<input>').attr({ type: 'hidden', name: 'versement' }).appendTo('#associationForm');
                    }

                    // Mettre à jour les valeurs des inputs cachés
                    ventesInput.val(selectedVentes.join(','));
                    versementInput.val(id_versement);

                    $('#associationForm').submit();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aucune sélection',
                        text: 'Veuillez sélectionner au moins une vente à associer.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Gérer la fermeture de la modale via le bouton "Fermer" ou en cliquant sur l'overlay
            $('.close-modal').on("click", function(e) {
                e.preventDefault();
                $("#ventes-list-modal").addClass("hidden");
                // Réinitialiser les checkboxes de la modale à la fermeture
                $('.vente-checkbox').prop('checked', false);
                $('#all-checkbox').prop('checked', false);
            });

            // Fermeture de la modale en cliquant sur l'overlay
            $('#ventes-list-modal').on('click', function(e) {
                if ($(e.target).is('#ventes-list-modal')) {
                    $('#ventes-list-modal').addClass('hidden');
                    $('.vente-checkbox').prop('checked', false);
                    $('#all-checkbox').prop('checked', false);
                }
            });

            // Fonctions de suppression des versements (Refactorisées pour être plus DRY)
            const setupDeleteHandler = (tableId) => {
                $(`#${tableId}`).on("click", ".delete", function() {
                    var id = $(this).closest('tr').attr("id");
                    var token = $("meta[name='csrf-token']").attr("content");
                    Swal.fire({
                        title: "Êtes-vous sûr(e) ?",
                        text: "Cette opération est irréversible et supprimera le versement.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Oui, supprimer !",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/commercial/deleteVersement/" + id,
                                dataType: "json",
                                data: {
                                    "_token": token,
                                },
                                method: "DELETE",
                                success: function(res) {
                                    Swal.fire(
                                        'Supprimé !',
                                        res.message,
                                        'success'
                                    );
                                    window.location.reload(); // Recharger la page pour voir le changement
                                },
                                error: function(xhr, status, err) {
                                    Swal.fire(
                                        'Erreur !',
                                        'Une erreur est survenue lors de la suppression.',
                                        'error'
                                    );
                                    console.error(xhr);
                                    console.error(status);
                                    console.error(err);
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire("Suppression annulée", "", "info");
                        }
                    })
                })
            };

            // Appliquer le gestionnaire de suppression à toutes les tables
            setupDeleteHandler("table1");
            setupDeleteHandler("table2");
            setupDeleteHandler("table3");
        });
    </script>
@endsection