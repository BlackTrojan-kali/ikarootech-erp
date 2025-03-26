@extends('Layouts.DirectionLayout')
@section('content')
    <h1 class="text-center font-bold text-2xl my-4">Accueil</h1>
    <div class="w-full mx-5  grid grid-cols-2 gap-10">
        @foreach ($region as $reg)
            <h1 class="underline text-xl font-bold"> {{ strtoupper($reg->region) }}</h1> <br>
            @foreach ($stocks as $stock)
                <?php
                $percent = ($stock->qty / 30000) * 100;
                ?>
                @if ($stock->region == $reg->region)
                    <div class="relative w-7/12">
                        <div class="w-11/12 flex justify-between font-bold">
                            <p>{{ env('COMPANIE_NAME') }} <span
                                    class="genera;">{{ $stock->article->weight > 0 ? $stock->article->weight . 'kg' : '' }}
                                </span>
                                @if ($stock->type == 'bouteille-gaz')
                                    <span class="text-green-500">{{ $stock->article->state ? 'pleine' : 'vide' }}</span>
                                @endif <span class="text-orange-500">{{ $stock->region }}
                                    {{ $stock->category }}</span>
                            </p>
                            <p>{{ $stock->qty }}</p>
                        </div>
                        <div class="w-full bg-gray-300 h-8 rounded-e-full">

                        </div>
                        <div class="primary h-8 top-6   rounded-e-full absolute" style="width:{{ $percent }}%"></div>
                    </div>
                @endif
            @endforeach
        @endforeach

    </div>
@endsection
