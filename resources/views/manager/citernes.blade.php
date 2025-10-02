@extends('Layouts.ManagerLayout')

@section('content')
    <div class="container mx-auto px-4 py-8"> {{-- Utilisation d'un conteneur pour centrer et ajouter du padding --}}
        <h1 class="font-bold text-2xl text-center mb-6">État du Stock</h1> {{-- Ajout de marge en bas --}}

        <div class="overflow-x-auto shadow-md rounded-lg"> {{-- Conteneur pour le défilement horizontal et les styles de tableau --}}
            <table class="min-w-full leading-normal"> {{-- Utilisation de min-w-full pour que le tableau prenne 100% de la largeur du conteneur parent et leading-normal pour l'interlignage par défaut --}}
                <thead class="text-white font-bold text-center bg-gray-700"> {{-- Couleur de fond légèrement plus foncée pour le thead --}}
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-xs font-semibold uppercase tracking-wider">S/L</th> {{-- Ajout de padding, bordures, alignement et styles de texte --}}
                        <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-xs font-semibold uppercase tracking-wider">Citerne</th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-xs font-semibold uppercase tracking-wider">Stock Théo.</th> {{-- Correction de l'abréviation --}}
                        <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-xs font-semibold uppercase tracking-wider">Stock Rél.</th> {{-- Correction de l'abréviation --}}
                        <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-xs font-semibold uppercase tracking-wider">Écart</th> {{-- Correction de l'accent --}}
                        <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-xs font-semibold uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white"> {{-- Utilisation d'un fond blanc pour la tbody pour un meilleur contraste --}}
                    @foreach ($fixe as $fix)
                        <tr class="hover:bg-gray-100"> {{-- Ajout d'un effet hover --}}
                            <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $fix->id }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $fix->name }}-{{ $fix->type }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $fix->stock[0]->stock_theo }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $fix->stock[0]->stock_rel }}</td>
                            @php
                                $ecart = $fix->stock[0]->stock_rel - $fix->stock[0]->stock_theo;
                            @endphp
                            <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                @if ($ecart > 0)
                                    <span class="text-green-600 font-semibold">{{ $ecart }}</span> {{-- Nuance de vert plus foncée et semi-gras --}}
                                @else
                                    <span class="text-red-600 font-semibold">{{ $ecart }}</span> {{-- Nuance de rouge plus foncée et semi-gras --}}
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                <div class="flex flex-col space-y-2 items-center"> {{-- Utilisation de flexbox pour aligner les boutons verticalement et ajouter de l'espace --}}
                                    <a href="{{ route('makeRel', ['id' => $fix->id]) }}" class="block"> {{-- Utilisation de 'block' pour que le lien prenne toute la largeur disponible pour le bouton --}}
                                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out"> {{-- Amélioration des styles de bouton --}}
                                            Nouveau relevé
                                        </button>
                                    </a>
                                    <b class="block">
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out"> {{-- Couleur différente pour distinguer les actions --}}
                                            Modifier Stock Théo.
                                        </button>
                                    </b>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection