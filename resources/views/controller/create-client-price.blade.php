@extends('Layouts.controllerLayout')
@section('content')
    <div class="w-full">
        <center>

            <div class="w-6/12 border-2 border-gray-300">
                <div class="modal-head">
                    <h1>Creer un nouveau prix pour client</h1>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" class="p-2" action="{{ route('store-client-price') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Client:</label>
                        <select name="client">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('client'))
                            <b class="text-red-500">{{ $errors->first('client') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Article:</label>
                        <select name="article">
                            @foreach ($articles as $article)
                                @if ($article->type == 'accessoire')
                                    <option value="{{ $article->id }}">
                                        {{ $article->title }}

                                    </option>
                                @else
                                    @if ($article->state > 0)
                                        <option value="{{ $article->id }}">
                                            {{ $article->type }} {{ $article->weight . ' KG' }}

                                        </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('article'))
                            <b class="text-red-500">{{ $errors->first('article') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Prix:</label>
                        <input type="number" name="price">
                        @if ($errors->has('price'))
                            <b class="text-red-500">{{ $errors->first('price') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Prix Consigne:</label>
                        <input type="number" name="consigne_price">
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
