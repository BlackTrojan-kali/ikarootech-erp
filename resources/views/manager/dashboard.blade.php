@extends('Layouts.ManagerLayout')
@section('content')
    <h1 class="text-center font-bold text-2xl my-4">Accueil</h1>
    <div class="w-full mx-5  grid grid-cols-2 gap-10 info">
        @foreach ($stocks as $stock)
            <?php
            $percent = ($stock->qty / 30000) * 100;
            ?>
            <div class="relative w-6/12 ">
                <div class="w-11/12 flex justify-between font-bold ">
                    <p>{{ env('COMPANIE_NAME') }} <span
                            class="general">{{ $stock->article->weight > 0 ? $stock->article->weight . 'kg' : '' }} </span>
                        @if ($stock->type == 'bouteille-gaz')
                            <span class="text-green-500">{{ $stock->article->state ? 'pleine' : 'vide' }}</span>
                    </p>
        @endif
        <p>{{ $stock->qty }}</p>
    </div>
    <div class="w-full bg-gray-300 h-8 rounded-e-full relative ">

        <div class="primary h-8 top-0 rounded-e-full absolute " style="width:{{ $percent }}%"></div>
    </div>
    </div>
    @endforeach
    </div>
@endsection
