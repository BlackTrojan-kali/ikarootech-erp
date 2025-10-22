@extends('Layouts.controllerLayout')
@section('content')
    <div class="w-full">
        <center>

            <div class="w-6/12 border-2 border-gray-300">
                <div class="modal-head">
                    <h1>Modifier le prix client</h1>
                    
                    <span><a href="{{ route("client-price") }}">X</a></span>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" class="p-2" action="{{ route('update-price', ['id' => $price->id]) }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Categorie:</label>
                        <input type="text" name="nom"
                            value="{{ $price->client->name }}" disabled>
                    </div>
                    <div class="modal-champs">
                        <label for="">Article:</label>
                        @if ($price->article->type == 'accessoire')
                            <input type="text" name="article" value="{{ $price->article->title }}" disabled>
                        @else
                            <input type="text" name="article"
                                value="{{ $price->article->type . ' ' . $price->article->weight . ' kg' }}" disabled>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label>Price:</label>
                        <input type="number" min="0" value="{{ $price->unite_price }}" name="price" />
                        @if ($errors->has('price'))
                            <p class="text-red-500">{{ $erros->first('price') }}</p>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Prix Consigne:</label>
                        <input type="number" name="consigne_price" min="0" value="{{ $price->consigne_price }}">
                        @if ($errors->has('consigne_price'))
                            <b class="text-red-500">{{ $errors->first('consigne_price') }}</b>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
@endsection
