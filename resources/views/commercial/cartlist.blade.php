@extends('Layouts.comLayout')
@section('content')
    <div>

        <center>
            <div class="w-2/4 border border-slate-300 rounded-md my-4">
                <div class="bg-slate-500 text-white p-3 ">
                    <h1>Formulaire de ventes/Consigne</h1>
                </div>

                List des elements
                <div class="flex flex-col gap-2 w-full p-2 ">
                    @foreach (Cart::content() as $row)
                        <div class="font-bold w-full flex gap-4  p-2  shadow-lg rounded-md bg-slate-200 ">
                            <h1 class="mt-2">{{ $row->name == 'stargas' ? 'bouteille-gaz' : $row->name }}
                                {{ $row->weight > 0 ? $row->weight . ' kg' : '' }}
                            </h1>
                            <form class="flex w-4/6 gap-4" method="POST" action="{{ route('updateCart', [$row->rowId]) }}">
                                @csrf
                                <input type="hidden" class="flex" name="rowId" value="{{ $row->rowId }}">
                                <div>
                                    <label for="">Qte:</label>
                                    <input class="bg-gray-300  border p-1 border-black rounded-md" type="number"
                                        name="qtyup" value="{{ $row->qty }}"> <br>
                                </div>
                                <div class="flex gap-4 justify-between h-10">

                                    <a href="{{ route('deleteItem', ['id' => $row->rowId]) }}"
                                        class="bg-red-500 text-white p-2 rounded-md">Supprimer</a>

                                    <button type="submit"
                                        class="bg-gray-200 p-2 rounded-md border border-black">Modifier</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>

                <button id="add-products-form" class="p-2 text-white primary rounded-md">Selectionner un article</button>

                <form method="POST" class="p-4 " action="{{ route('validateCart') }}">
                    @csrf
                    <div class="champs">
                        <label for="">Client:</label>
                        <select name="client" id="" class="w-full p-2 border border-black">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom . ' ' . $client->prenom }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('client'))
                            <p class="text-red-500">{{ $errors->first('client') }}</p>
                        @endif

                    </div>
                    <div class="champs">
                        <label for="">mode de paiement:</label>
                        <select name="currency" id="" class="w-full p-2 border border-black">
                            <option value="Cash">Cash</option>
                            <option value="Virement">Virement</option>
                        </select>

                        @if ($errors->has('currency'))
                            <p class="text-red-500">{{ $errors->first('currency') }}</p>
                        @endif
                    </div>
                    <div class="champs">
                        <label for="">Type d'operation:</label>
                        <select name="type" id="" class="w-full p-2 border border-black">
                            <option value="vente">Vente</option>
                            <option value="consigne">Consigne</option>
                        </select>

                        @if ($errors->has('currency'))
                            <p class="text-red-500">{{ $errors->first('currency') }}</p>
                        @endif
                    </div>
                    <div class="champs">
                        <label for="">somme percue:</label>
                        <input type="number" name="amount" required>
                        @if ($errors->has('amount'))
                            <p class="text-red-500">{{ $errors->first('amount') }}</p>
                        @endif
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="reset" class="p-2 bg-black  text-white rounded-md">annuler</button>
                        <button type="submit" class="p-2 primary  text-white rounded-md">Valider</button>
                    </div>
                </form>
            </div>
        </center>
    </div>

    <div id="add-products" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Selectionner un Article</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('addTocart') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Article:</label>
                        <select name="article" id="">
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}">
                                    {{ $article->type == 'accessoire' ? $article->title : $article->type . ' ' . $article->weight . ' KG' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('article'))
                            <b class="text-red-500">{{ $errors->first('article') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Qte:</label>
                        <input type="number" name="qty">
                        @if ($errors->has('qty'))
                            <b class="text-red-500">{{ $errors->first('qty') }}</b>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <script type="module">
        $(function() {
            //ACTION versement historique
            $("#add-products-form").on("click", function(e) {
                e.preventDefault()
                if ($("#add-products").hasClass("modals")) {
                    $("#add-products").addClass("modals-active");
                    $("#add-products").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#add-products").hasClass("modals-active")) {
                        $("#add-products").addClass("modals");
                        $("#add-products").removeClass("modals-active");
                    }
                })
            })
        })
    </script>
@endsection
