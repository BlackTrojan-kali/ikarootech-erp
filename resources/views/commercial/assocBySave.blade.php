@extends("Layouts.comLayout")

@section("content")

    {{-- MODALE POUR LA LISTE DES VENTES À ASSOCIER --}}
    {{-- Cette div sera stylisée comme une modale pour un meilleur UX --}}
    <div id="ventes-list-modal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-white p-6 rounded-md border border-black shadow-lg w-full max-w-4xl mx-auto my-8 overflow-y-auto max-h-[90vh]">
            {{-- MODIFICATION ICI : Utilisation de justify-between pour aligner à gauche et à droite --}}
            <div class="flex justify-between items-center mb-4">
                {{-- Bouton "Fermer" à gauche --}}
                <a href="{{ route("dashboardCom") }}" class="secondary text-white p-2 rounded-md">Fermer</a>
                {{-- Bouton "Associer" à droite --}}
                <button class="primary text-white p-2 rounded-md" id="associate-button">Associer</button>
            </div>

            <h1 class="text-xl font-bold text-center mb-4">Liste des ventes à associer au versement</h1>

            <div class="flex justify-between items-center mb-4">
                {{-- Ce bouton "Associer" est redondant s'il y en a déjà un en haut. Je le laisse commenté. --}}
                {{-- <button class="primary text-white p-2 rounded-md" id="associate-button">Associer</button> --}}
                <div class="flex items-center">
                    <label for="all-checkbox" class="mr-2 text-gray-700">Sélectionner tout</label>
                    <input type="checkbox" id="all-checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                </div>
            </div>

            <form id="associationForm" action="{{ route("assoc_versement_vente") }}" method="POST">
            @csrf
                <div class="overflow-x-auto">
                    <table id="ventesTable" class="min-w-full leading-normal border border-black rounded-md">
                        <thead class="bg-gray-200 text-gray-700">
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
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $invoice->type }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                        <input type="checkbox" class="vente-checkbox form-checkbox h-4 w-4 text-blue-600 rounded" value="{{ $invoice->id }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td  class="px-5 py-5 border-b border-gray-200 text-sm text-center text-gray-500">Aucune vente disponible pour l'association.</td>
                                    <td>/</td>
                                    <td>/</td>
                                    <td>/</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <script type="module">
        $(function() {
            let id_versement = {{ $idVer }};
            let oTable = $('#ventesTable').DataTable({
                "paging": false,
                "searching": false,
                "info": false,
            });

            $('#all-checkbox').click(function () {
                $('.vente-checkbox').prop('checked', $(this).is(':checked'));
            });

            $('#associate-button').click(function() {
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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aucune sélection',
                        text: 'Veuillez sélectionner au moins une vente à associer.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $('#ventes-list-modal').removeClass('hidden');

            $('#ventes-list-modal').on('click', function(e) {
                if ($(e.target).is('#ventes-list-modal')) {
                    $('#ventes-list-modal').addClass('hidden');
                }
            });
        });
    </script>
@endsection