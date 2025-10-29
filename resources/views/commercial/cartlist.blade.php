@extends('Layouts.comLayout')

@section('content')
    <div class="container mx-auto px-4"> {{-- Main container for centering and padding --}}

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-4xl mx-auto my-4" role="alert">
                <strong class="font-bold">Succès!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl mx-auto my-4">
            <div class="bg-slate-500 text-white p-4 rounded-t-lg flex justify-between items-center">
                <h1 class="text-xl font-semibold">Formulaire de Ventes/Consigne</h1>
                <a href="{{ route('dashboardCom') }}" class="text-white hover:text-gray-200 text-2xl font-bold">&times;</a>
            </div>

            <h2 class="text-lg font-bold mt-6 mb-4 text-gray-700">Liste des éléments (Prix unitaire inclus)</h2>
            
            {{-- Début du Tableau pour les Articles --}}
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 shadow-md rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qté</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse (Cart::content() as $row)
                        <tr class="hover:bg-gray-50">
                            {{-- NOM & POIDS --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <h3 class="text-gray-800 font-medium">
                                    {{ $row->name == 'stargas' ? 'Bouteille-gaz' : $row->name }}
                                    @if ($row->weight > 0)
                                        <span class="text-gray-500 text-sm">({{ $row->weight }} kg)</span>
                                    @endif
                                </h3>
                            </td>

                            {{-- QUANTITÉ --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form class="flex items-center gap-2" method="POST" action="{{ route('updateCart', [$row->rowId]) }}">
                                    @csrf
                                    <input type="hidden" name="rowId" value="{{ $row->rowId }}">
                                    <input disabled class="bg-gray-300 border border-black p-1 rounded-md w-16 text-center text-sm" type="number" name="qtyup" value="{{ $row->qty }}">
                                </form>
                            </td>

                            {{-- PRIX UNITAIRE (AVEC CONSIGNÉ) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="font-bold text-green-600 mb-1">
                                    {{ number_format($row->price, 2, ',', ' ') }}
                                </div>
                                {{-- Afficher le prix de consigne si disponible dans les options --}}
                                @if (isset($row->options['consigne_price']) && $row->options['consigne_price'] > 0)
                                <div class="text-gray-500 text-xs font-normal">
                                    (+ {{ number_format($row->options['consigne_price'], 2, ',', ' ') }} Cons.)
                                </div>
                                @endif
                            </td>

                            {{-- TOTAL PAR LIGNE --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right font-extrabold text-gray-800">
                                {{ number_format($row->total, 2, ',', ' ') }}
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('deleteItem', ['id' => $row->rowId]) }}" class="bg-red-500 text-white p-2 rounded-md hover:bg-red-600 transition duration-150 text-sm">Supprimer</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun article sélectionné.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-lg font-bold text-gray-800">TOTAL HT:</td>
                            <td class="px-6 py-3 text-right text-lg font-extrabold text-blue-600">
                                {{ Cart::subtotal(2, ',', ' ') }} 
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- Fin du Tableau pour les Articles --}}

            <div class="text-center mt-6 flex justify-center items-center gap-4">
                <button id="add-products-form-button" class="p-2 text-white primary rounded-md shadow-md">
                    Sélectionner un article
                </button>
                
                {{-- Bouton pour vider le panier --}}
                @if (Cart::count() > 0)
                <a href="{{ route('destroyCart') }}" class="p-2 bg-red-700 text-white rounded-md shadow-md hover:bg-red-800 transition duration-150" 
                    onclick="return confirm('Êtes-vous sûr de vouloir vider complètement le panier, monsieur ?')">
                    Vider le Panier ({{ Cart::count() }})
                </a>
                @endif
            </div>

            <form method="POST" class="p-4 border-t border-gray-200 mt-4" action="{{ route('validateCart') }}" id="validate-cart-form">
                @csrf
                <div class="mb-4">
                    <label for="client" class="block text-gray-700 text-sm font-bold mb-2">Client:</label>
                    {{-- Désactive le select si le panier n'est pas vide --}}
                    <select name="client" id="client" class="clients w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        @if(Cart::count() > 0) disabled @endif>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom . ' ' . $client->prenom }}</option>
                        @endforeach
                    </select>
                    @if(Cart::count() > 0)
                        {{-- Ajout d'un champ caché pour s'assurer que l'ID du client est envoyé même si le champ est désactivé --}}
                        <input type="hidden" name="client" value="{{ old('client', $clients->firstWhere('id', old('client')) ? old('client') : ($clients->first()->id ?? '')) }}">
                        <p class="text-sm text-yellow-600 mt-1">Le client est verrouillé car le panier contient des articles. Videz le panier pour changer de client.</p>
                    @endif
                    @error('client')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Mode de paiement:</label>
                    <select name="currency" id="currency" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option value="Cash">Cash</option>
                        <option value="Virement">Virement</option>
                    </select>
                    @error('currency')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="operation_type" class="block text-gray-700 text-sm font-bold mb-2">Type d'opération:</label>
                    <select name="type" id="operation_type" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option value="" disabled>Choisir un type d'operation</option>
                        <option value="vente">Vente</option>
                        <option value="consigne">Consigne</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="reset" class="p-2 bg-black text-white rounded-md">Annuler</button>
                    <button type="submit" class="p-2 primary text-white rounded-md" @if(Cart::count() == 0) disabled @endif>
                        Valider
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL FOR SELECTING AN ITEM --}}
    <div id="add-products" class="modal-overlay hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative transform transition-all sm:my-8 sm:w-full">
            <div class="modal-head flex justify-between items-center border-b pb-3 mb-4">
                <h1 class="text-xl font-semibold text-gray-800">Sélectionner un Article</h1>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
            </div>
            <span class="success text-green-500 block mb-2 font-medium"></span>
            <span class="errors text-red-500 block mb-4 font-medium"></span>
            <form method="POST" action="{{ route('addTocart') }}" id="add-to-cart-form">
                @csrf
                {{-- Champ caché pour le client ID --}}
                <input type="hidden" name="client_id" id="modal_client_id" value=""> 

                <div class="mb-4">
                    <label for="article" class="block text-gray-700 text-sm font-bold mb-2">Article:</label>
                    <select name="article" id="article" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        @foreach ($articles as $article)
                            <option value="{{ $article->id }}">
                                {{ $article->type == 'accessoire' ? $article->title : $article->type . ' ' . $article->weight . ' KG' }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('article'))
                        <p class="text-red-500 text-xs italic mt-1">{{ $errors->first('article') }}</p>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="qty" class="block text-gray-700 text-sm font-bold mb-2">Quantité:</label>
                    <input type="number" name="qty" id="qty" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300" required min="1"> 
                    @if ($errors->has('qty'))
                        <p class="text-red-500 text-xs italic mt-1">{{ $errors->first('qty') }}</p>
                    @endif
                </div>
                <div class="flex justify-end gap-3">
                    <button type="reset" class="p-2 bg-gray-500 text-white rounded-md close-modal">Annuler</button>
                    <button type="submit" id="submit-article-button" class="p-2 primary text-white rounded-md">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <script type="module">
        $(document).ready(function() {
            // Select2 initialization
            $(".clients").select2({
                placeholder: "Sélectionnez un client",
                allowClear: true,
            });

            // Initialiser l'ID du client dans le champ caché de la modale
            $('#modal_client_id').val($('#client').val());

            // Mettre à jour l'ID du client dans la modale lorsque la sélection change
            $('#client').on('change', function() {
                $('#modal_client_id').val($(this).val());
                // Mettre à jour le champ caché pour le formulaire principal aussi, au cas où il était désactivé
                $('input[name="client"]').val($(this).val());
            });


            // Function to open a modal
            function openModal(modalId) {
                $('#' + modalId).removeClass('hidden');
                // Reset messages when modal opens
                $('.success').text('');
                $('.errors').text('');
            }

            // Function to close all modals
            function closeModals() {
                $('.modal-overlay').addClass('hidden');
                // Reset form fields after closing
                $('#add-to-cart-form')[0].reset();
                // Reset messages
                $('.success').text('');
                $('.errors').text('');
            }

            // Open "Select an item" modal
            $("#add-products-form-button").on("click", function(e) {
                e.preventDefault();
                // S'assurer que le client ID actuel est copié avant d'ouvrir
                $('#modal_client_id').val($('#client').val());
                openModal('add-products');
            });

            // Close modals via "X" or "Cancel" button
            $('.close-modal').on("click", function(e) {
                e.preventDefault();
                closeModals();
            });

            // Close modal by clicking outside the modal content
            $('.modal-overlay').on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    closeModals();
                }
            });

            // Soumission du formulaire d'ajout au panier via AJAX
            $('#add-to-cart-form').on('submit', function(e) {
                e.preventDefault(); 

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();
                var submitButton = $('#submit-article-button');

                // Désactiver le bouton et changer le texte
                submitButton.prop('disabled', true).text('Ajout en cours...');

                // Clear previous messages before new submission
                $('.success').text('');
                $('.errors').text('');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        // Réactiver le bouton et restaurer le texte
                        submitButton.prop('disabled', false).text('Ajouter');
                        
                        if (response.success) {
                            $('.success').text(response.success);
                            // Close modal and refresh page after a short delay
                            setTimeout(function() {
                                closeModals(); // Close modal first
                                location.reload(); // Refresh the page to show the updated cart with price
                            }, 1000); // 1-second delay to show the message
                        }
                    },
                    error: function(xhr) {
                        // Réactiver le bouton et restaurer le texte en cas d'erreur
                        submitButton.prop('disabled', false).text('Ajouter');

                        var errorMessages = [];
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // If server returned validation errors in JSON
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessages.push(value[0]);
                            });
                        } else if (xhr.status === 404 && xhr.responseJSON) {
                            // Erreur spécifique du contrôleur (prix non trouvé)
                            errorMessages.push(xhr.responseJSON.errors[0]);
                        } else if (xhr.status) {
                            // Specific HTTP error without JSON (e.g., 404, 500)
                            errorMessages.push('Erreur ' + xhr.status + ': ' + xhr.statusText + '.');
                            console.error('Full error response:', xhr.responseText); 
                        } else {
                            // Network error or other unknown issue
                            errorMessages.push('Une erreur de communication est survenue. Vérifiez votre connexion.');
                        }
                        $('.errors').text(errorMessages.join(' / ')); // Affiche les erreurs
                    }
                });
            });

            // Soumission du formulaire de validation du panier via AJAX
            $('#validate-cart-form').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();
                var submitButton = form.find('button[type="submit"]');

                submitButton.prop('disabled', true).text('Validation en cours...');


                // Clear previous messages before new submission
                $('.success').text('');
                $('.errors').text('');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        submitButton.prop('disabled', false).text('Valider');
                        if (response.success && response.pdf && response.filename) {
                            var link = document.createElement('a');
                            link.href = 'data:application/pdf;base64,' + response.pdf;
                            link.download = response.filename; 
                            document.body.appendChild(link);
                            link.click(); 
                            document.body.removeChild(link); 

                            $('.success').text(response.success);
                            // Rafraîchir la page après le téléchargement et un court délai
                            setTimeout(function() {
                                location.reload();
                            }, 1500); 
                        } else if (response.errors) {
                            $('.errors').text(response.errors.join(', '));
                        } else {
                            $('.errors').text('Une erreur inattendue est survenue lors de la validation.');
                        }
                    },
                    error: function(xhr) {
                        submitButton.prop('disabled', false).text('Valider');
                        var errorMessages = [];
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessages.push(value[0]);
                            });
                        } else if (xhr.status) {
                            errorMessages.push('Erreur ' + xhr.status + ': ' + xhr.statusText + '.');
                            console.error('Full error response (validateCart):', xhr.responseText);
                        } else {
                            errorMessages.push('Une erreur de communication est survenue lors de la validation. Vérifiez votre connexion.');
                        }
                        $('.errors').text(errorMessages.join(', '));
                    }
                });
            });
        });
    </script>
@endsection