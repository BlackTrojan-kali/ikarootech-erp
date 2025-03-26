@extends('Layouts.controllerLayout')
@section('content')
    <div class="w-full">
        <center>

            <div class="w-6/12 border-2 border-gray-300">
                <div class="modal-head">
                    <h1>Modifier le prix client</h1>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" class="p-2" action="{{ route('update-price', ['id' => $price->id]) }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Client:</label>
                        <input type="text" name="nom"
                            value="{{ $price->client->nom . ' ' . $price->client->prenom }}" disabled>
                    </div>
                    <div class="modal-champs">
                        <label for="">Article:</label>
                        @if ($price->article->type == 'accessoire')
                            <input type="text" name="article" value="{{ $price->article->title }}" disabled>
                        @else
                            <input type="text" name="article"
                                value="{{ $price->article->type . ' ' . $price->article->wieght . ' kg' }}" disabled>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label>Price:</label>
                        <input type="number" value="{{ $price->unite_price }}" name="price" />
                        @if ($errors->has('price'))
                            <p class="text-red-500">{{ $erros->first('price') }}</p>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Prix Consigne:</label>
                        <input type="number" name="consigne_price" value="{{ $price->consigne_price }}">
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
