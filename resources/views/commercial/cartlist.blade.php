@extends('Layouts.comLayout')

@section('content')
    <div class="container mx-auto px-4"> {{-- Main container for centering and padding --}}

        <div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl mx-auto my-4"> {{-- Styling for the main block --}}
            <div class="bg-slate-500 text-white p-4 rounded-t-lg flex justify-between items-center"> {{-- Header of the block with original color --}}
                <h1 class="text-xl font-semibold">Formulaire de Ventes/Consigne</h1> {{-- Clear title --}}
                <a href="{{ route('dashboardCom') }}" class="text-white hover:text-gray-200 text-2xl font-bold">&times;</a> {{-- Styled close button --}}
            </div>

            <h2 class="text-lg font-bold mt-6 mb-4 text-gray-700">Liste des éléments</h2> {{-- Title for the list of items --}}
            <div class="flex flex-col gap-3 w-full p-2"> {{-- Space between list items --}}
                @forelse (Cart::content() as $row) {{-- Using @forelse to han
                dle empty cart --}}
                
                <div class="font-semibold w-full flex flex-col md:flex-row items-center justify-between gap-4 p-3 shadow-md rounded-lg bg-slate-200 border border-gray-200"> {{-- Original background color --}}
                        <h3 class="text-gray-800 text-base md:text-lg mb-2 md:mb-0">
                            {{ $row->name == 'stargas' ? 'Bouteille-gaz' : $row->name }}
                            @if (isset($row->weight ) && $row->weight > 0)
                                <span class="text-gray-700">{{ $row->weight }} kg</span> {{-- Access weight via options --}}
                            @endif
                        </h3>
                        <form class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto" method="POST" action="{{ route('updateCart', [$row->rowId]) }}">
                            @csrf
                            <input type="hidden" name="rowId" value="{{ $row->rowId }}">
                            <div class="flex items-center gap-2">
                                <label for="qty-{{ $row->rowId }}" class="text-gray-700 text-sm">Quantité:</label>
                                <input id="qty-{{ $row->rowId }}" disabled class="bg-gray-300 border border-black p-2 rounded-md w-20 text-center" type="number" name="qtyup" value="{{ $row->qty }}"> {{-- Original colors --}}
                            </div>
                            <div class="flex gap-2 h-10 items-center">
                                <a href="{{ route('deleteItem', ['id' => $row->rowId]) }}" class="bg-red-500 text-white p-2 rounded-md">Supprimer</a> {{-- Original color --}}

                                {{-- If the modify button is re-added, style it as follows:
                                <button type="submit" class="bg-gray-200 p-2 rounded-md border border-black">Modifier</button>
                                --}}
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Aucun article sélectionné.</p>
                @endforelse
            </div>

            <div class="text-center mt-6 mb-8">
                <button id="add-products-form-button" class="p-2 text-white primary rounded-md shadow-md"> {{-- 'primary' class preserved --}}
                    Sélectionner un article
                </button>
            </div>

            <form method="POST" class="p-4 border-t border-gray-200 mt-4" action="{{ route('validateCart') }}" id="validate-cart-form"> {{-- Added ID here --}}
                @csrf
                <div class="mb-4"> {{-- Using mb-x for spacing --}}
                    <label for="client" class="block text-gray-700 text-sm font-bold mb-2">Client:</label>
                    <select name="client" id="client" class="clients w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300"> {{-- Black border preserved --}}
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom . ' ' . $client->prenom }}</option>
                        @endforeach
                    </select>
                    @error('client')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Original color --}}
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Mode de paiement:</label>
                    <select name="currency" id="currency" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300"> {{-- Black border preserved --}}
                        <option value="Cash">Cash</option>
                        <option value="Virement">Virement</option>
                    </select>
                    @error('currency')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Original color --}}
                    @enderror
                </div>
                <div class="mb-6"> {{-- Larger margin for the last field before buttons --}}
                    <label for="operation_type" class="block text-gray-700 text-sm font-bold mb-2">Type d'opération:</label>
                    <select name="type" id="operation_type" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300"> {{-- Black border preserved --}}
                        <option value="vente">Vente</option>
                        <option value="consigne">Consigne</option>
                    </select>
                    @error('type') {{-- Error correction for 'type' field --}}
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Original color --}}
                    @enderror
                </div>
                <div class="flex justify-end gap-3 mt-4"> {{-- Button alignment to the right with spacing --}}
                    <button type="reset" class="p-2 bg-black text-white rounded-md">Annuler</button> {{-- Original color --}}
                    <button type="submit" class="p-2 primary text-white rounded-md">Valider</button> {{-- 'primary' class preserved --}}
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL FOR SELECTING AN ITEM --}}
    <div id="add-products" class="modal-overlay hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative transform transition-all sm:my-8 sm:w-full">
            <div class="modal-head flex justify-between items-center border-b pb-3 mb-4">
                <h1 class="text-xl font-semibold text-gray-800">Sélectionner un Article</h1>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button> {{-- 'X' color preserved --}}
            </div>
            <span class="success text-green-500 block mb-2 font-medium"></span> {{-- Improved message styling --}}
            <span class="errors text-red-500 block mb-4 font-medium"></span> {{-- Improved message styling --}}
            <form method="POST" action="{{ route('addTocart') }}" id="add-to-cart-form">
                @csrf
                <div class="mb-4">
                    <label for="article" class="block text-gray-700 text-sm font-bold mb-2">Article:</label>
                    <select name="article" id="article" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300"> {{-- Black border preserved --}}
                        @foreach ($articles as $article)
                            <option value="{{ $article->id }}">
                                {{ $article->type == 'accessoire' ? $article->title : $article->type . ' ' . $article->weight . ' KG' }}
                            </option>
                        @endforeach
                    </select>
                    {{-- Display specific article validation errors, if present --}}
                    @if ($errors->has('article'))
                        <p class="text-red-500 text-xs italic mt-1">{{ $errors->first('article') }}</p>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="qty" class="block text-gray-700 text-sm font-bold mb-2">Quantité:</label>
                    <input type="number" name="qty" id="qty" class="w-full p-2 border border-black rounded-md focus:outline-none focus:ring focus:border-blue-300" required min="1"> {{-- Black border preserved, added min="1" --}}
                    {{-- Display specific quantity validation errors, if present --}}
                    @if ($errors->has('qty'))
                        <p class="text-red-500 text-xs italic mt-1">{{ $errors->first('qty') }}</p>
                    @endif
                </div>
                <div class="flex justify-end gap-3">
                    <button type="reset" class="p-2 bg-gray-500 text-white rounded-md close-modal">Annuler</button> {{-- Original color (btn-secondary) --}}
                    <button type="submit" id="submitForm" class="p-2 primary text-white rounded-md">Ajouter</button> {{-- 'primary' class preserved --}}
                </div>
            </form>
        </div>
    </div>

    <script type="module">
        $(document).ready(function() {
            // Select2 initialization
            $(".clients").select2({
                placeholder: "Sélectionnez un client",
                allowClear: true // Optional: allows deselection
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
                e.preventDefault(); // Empêche la soumission normale du formulaire

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();

                // Clear previous messages before new submission
                $('.success').text('');
                $('.errors').text('');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            $('.success').text(response.success);
                            // Close modal and refresh page after a short delay
                            setTimeout(function() {
                                closeModals(); // Close modal first
                                location.reload(); // Refresh the page
                            }, 1000); // 1-second delay to show the message
                        }
                    },
                    error: function(xhr) {
                        var errorMessages = [];
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // If server returned validation errors in JSON
                            for (var key in xhr.responseJSON.errors) {
                                errorMessages.push(xhr.responseJSON.errors[key][0]);
                            }
                        } else if (xhr.status) {
                            // Specific HTTP error without JSON (e.g., 404, 500)
                            errorMessages.push('Erreur ' + xhr.status + ': ' + xhr.statusText + '.');
                            console.error('Full error response:', xhr.responseText); // Log for debugging
                        } else {
                            // Network error or other unknown issue
                            errorMessages.push('Une erreur de communication est survenue. Vérifiez votre connexion.');
                        }
                        $('.errors').text(errorMessages.join(', '));
                    }
                });
            });

            // Soumission du formulaire de validation du panier via AJAX
            $('#validate-cart-form').on('submit', function(e) {
                e.preventDefault(); // Empêche la soumission normale du formulaire

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();

                // Clear previous messages before new submission
                $('.success').text('');
                $('.errors').text('');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        if (response.success && response.pdf && response.filename) {
                            // Créer un lien temporaire pour le téléchargement du PDF
                            var link = document.createElement('a');
                            link.href = 'data:application/pdf;base64,' + response.pdf;
                            link.download = response.filename; // Nom du fichier
                            document.body.appendChild(link);
                            link.click(); // Simuler un clic pour télécharger le fichier
                            document.body.removeChild(link); // Nettoyer l'élément temporaire

                            $('.success').text(response.success);
                            // Rafraîchir la page après le téléchargement et un court délai
                            setTimeout(function() {
                                location.reload();
                            }, 1500); // Délai de 1.5 secondes pour s'assurer que le téléchargement commence
                        } else if (response.errors) {
                            $('.errors').text(response.errors.join(', '));
                        } else {
                            $('.errors').text('Une erreur inattendue est survenue lors de la validation.');
                        }
                    },
                    error: function(xhr) {
                        var errorMessages = [];
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            for (var key in xhr.responseJSON.errors) {
                                errorMessages.push(xhr.responseJSON.errors[key][0]);
                            }
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