@extends('Layouts.controllerLayout')
@section('content')
    <div class="mt-8 p-2">
        <div class=" mb-2 flex justify-between p-3 ">
            <a href="{{ route('create-client-price') }}" class="p-4 bg-green-400 text-white font-bold">Ajouter un Prix</a>
            
            <button id="generate-pdf-btn" class="p-4 bg-purple-600 text-white font-bold hover:bg-purple-700">
                Générer Prix PDF
            </button>
        </div>
        
        <table id="table-1" class="w-full table-auto bg-slate-200 border-separate p-2">
            <thead class="text-center font-bold py-12">
                <tr class="">
                    <td>id</td>
                    <td>Nom Catégorie</td>
                    <td>Article</td>
                    <td>Prix GPL</td>
                    <td>Prix Consigne</td>
                    <td>Date</td>
                    <td>Région</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($prices as $price)
                    <tr class="mb-5 ">
                        <td>{{ $price->id }}</td>
                        <td>{{ $price->client->name }}</td> 
                        <td>
                            @if ($price->article->type == 'accessoire')
                                {{ $price->article->title }}
                            @else
                                {{ $price->article->type . ' ' . $price->article->weight . ' KG' }}
                            @endif
                        </td>
                        <td>
                            {{ $price->unite_price }} XAF
                        </td>
                        <td>
                            {{ $price->consigne_price }} XAF
                        </td>
                        <td>
                            {{ $price->created_at }}
                        </td>
                        <td>{{$price->region}}</td>
                        <td id={{ $price->id }}>
                            <a href="{{ route('edit-price', [$price->id]) }}"
                                class="px-4 p-1 rounded-md bg-blue-500 text-white"><i class="fa-solid fa-edit"></i></a>
                            <a class="delete px-4 p-1 rounded-md bg-red-500 text-white"><i
                                        class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="pdf-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-96">
            <h3 class="text-xl font-bold mb-4">Générer Liste de Prix (PDF)</h3>
            <form id="pdf-form" action="{{ route('generate-price-pdf') }}" method="GET"> 
                
                <div class="mb-4 w-full">
                    <label for="client_category_pdf" class="block text-gray-700 font-bold mb-2">Catégorie Client :</label>
                    <select id="client_category_pdf" name="id_cat" required
                            class="shadow border rounded  text-gray-700">
                        <option value="">-- Sélectionner une Catégorie --</option>
                        @foreach ($clientCats as $category) 
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 w-full">
                    <label for="article_name_pdf" class="block text-gray-700 font-bold mb-2">Article :</label>
                    <select id="article_name_pdf" name="id_article" required
                            class="shadow border rounded   text-gray-700">
                        <option value="">-- Sélectionner un article --</option>
                        @foreach ($articlesList as $article) 
                            @if($article->type == "bouteille-gaz")
                                <option value="{{ $article->id }}">{{ $article->weight ." kg" }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="cancel-pdf-btn" class="bg-gray-500 text-white font-bold py-2 px-4 rounded mr-2 hover:bg-gray-700">
                        Annuler
                    </button>
                    <button type="submit" class="bg-purple-600 text-white font-bold py-2 px-4 rounded hover:bg-purple-700">
                        Générer PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Initialisation de DataTables (existant)
            $('table').DataTable();

            // ------------------------------------------
            // ⭐️ INITIALISATION DE SELECT2 
            // ------------------------------------------

            // 1. Initialiser Select2 pour la Catégorie Client
            $('#client_category_pdf').select2({
                dropdownParent: $('#pdf-modal'), // Pour que le menu déroulant s'affiche correctement dans la modale
                placeholder: "-- Sélectionner une Catégorie --",
                allowClear: true
            });

            // 2. Initialiser Select2 pour l'Article
            $('#article_name_pdf').select2({
                dropdownParent: $('#pdf-modal'), // Pour que le menu déroulant s'affiche correctement dans la modale
                placeholder: "-- Sélectionner un article --",
                allowClear: true
            });
            
            // ------------------------------------------
            // --- Gestion de la MODALE PDF (Nouveau) ---
            // ------------------------------------------
            
            // Ouvrir la modale
            $("#generate-pdf-btn").on("click", function() {
                $("#pdf-modal").removeClass('hidden').addClass('flex');
                
                // Mettre à jour l'affichage de Select2 après ouverture de la modale pour éviter les problèmes de style
                $('#client_category_pdf').select2('open'); // Ouvre le sélecteur immédiatement
                $('#client_category_pdf').select2('close'); // Puis le referme si non désiré (ou retirez cette ligne)
                $('#article_name_pdf').select2('open');
                $('#article_name_pdf').select2('close');

            });

            // Fermer la modale (via bouton Annuler)
            $("#cancel-pdf-btn").on("click", function() {
                $("#pdf-modal").removeClass('flex').addClass('hidden');
            });

            // Fermer la modale (via clic en dehors)
            $("#pdf-modal").on("click", function(e) {
                if (e.target.id === 'pdf-modal') {
                    $(this).removeClass('flex').addClass('hidden');
                }
            });
            
            // --- Code de suppression (existant) ---
            $("#table-1").on("click", ".delete", function(e) {
                e.preventDefault()
                userId = $(this).parent().attr('id'); 
                Swal.fire({
                    title: "Êtes-vous sûr(e) ? Cette opération est irréversible.",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Supprimer",
                    denyButtonText: `Annuler`
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "delete-price/" + userId,
                            dataType: "json",
                            data: {
                                "id": userId,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire("Élément supprimé avec succès", "", "success");
                                $('table').DataTable().ajax.reload(null, false); 
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Erreur lors de la suppression.", "", "error");
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistré", "", "info");
                    }
                });
            })
        })
    </script>
@endsection