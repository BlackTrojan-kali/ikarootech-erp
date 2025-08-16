@extends('Layouts.ManagerLayout')

@section('content')
    <h1 class="text-center font-bold text-2xl my-4">Accueil</h1>

    {{-- Section d'information sur les stocks --}}
    <div class="w-full px-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10 info">
        @foreach ($stocks as $stock)
            @php
                // Calcul du pourcentage de remplissage, en supposant que 30000 est la capacité maximale
                $maxCapacity = 30000;
                $percent = ($stock->qty / $maxCapacity) * 100;
                // Assurer que le pourcentage ne dépasse pas 100% et n'est pas négatif
                $percent = max(0, min(100, $percent));
            @endphp
            <div class="relative w-full"> {{-- Utilisation de w-full pour que la div prenne toute la largeur de sa colonne --}}
                <div class="w-11/12 flex justify-between font-bold items-center"> {{-- Ajout de items-center pour l'alignement vertical --}}
                    <p>
                        
                        @if ($stock->type == 'bouteille-gaz')

                        {{ $stock->type }} 
                        <span class="general">   {{ $stock->article->weight > 0 ? $stock->article->weight . 'kg' : '' }}
                        </span>
                        
                            <span class="text-green-500">{{ $stock->article->state ? 'pleine' : 'vide' }}</span>
                    @else
                        {{ $stock->article->title }}
                        @endif
                    </p>
                    <p>{{ $stock->qty }}</p>
                </div>
                <div class="w-full bg-gray-300 h-8 rounded-e-full relative overflow-hidden"> {{-- Ajout de overflow-hidden pour les coins arrondis --}}
                    <div class="primary h-8 top-0 rounded-e-full absolute" style="width:{{ $percent }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection