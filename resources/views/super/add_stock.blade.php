@extends("Layouts.appLayout")
@section("content")
<?php
$name = "stargaz"
?>
<center class="w-full p-4">
    <h1 class="mb-3 text-xl font-bold">Enregistrer un nouveau stock</h1>
    <form action="{{route('post_stock')}}" method="POST" class="p-4 border border-blue-400 rounded-lg w-5/12">
        @csrf
      
        <div class="champs">
            <label for="">Article</label>
            <select name="article"  class="w-full p-3 font-bold" id="">
                @foreach ($articles as $article )
                    <option value="{{ $article->id }}">
@if ($article->title == "stargas")
    @if ($article->state == 1)
            {{ $article->weight." ".$article->unity." pleine" }}
            @else
            {{ $article->weight." ".$article->unity." videe" }}
    @endif
    @else
    {{ $article->title }}
@endif

                    </option>
                @endforeach
                @if ($errors->has("article"))
                    <p class="text-red-500">{{$errors->first('article')}}</p>
                @endif
            </select>
        </div>
        <div class="champs">
            <label for="">Region</label>
            <select name="region"  class="w-full p-3 font-bold" id="">
                @foreach ($regions as $region )
                    <option value="{{ $region->region }}">
                        {{ $region->region }}

                    </option>
                @endforeach
                @if ($errors->has("region"))
                    <p class="text-red-500">{{$errors->first('region')}}</p>
                @endif
            </select>
        </div>
        <br>
        <div class="w-full flex justify-end">
            <button class="text-white font-bold bg-blue-400 p-2" type="submit">Enregistrer </button>
        </div>
    </form>
</center>
@endsection