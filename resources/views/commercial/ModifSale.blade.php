@extends('Layouts.comLayout')
@section('content')
    <div>
        <!-- ventes FORMULAIRES -->
        <div>
            <center>
                <div class="modal-active w-full md-6/12">
                    <div class="modal-head">
                        <h1>Modifier {{ $sale->type }}</h1>
                        <b class="close-modal">X</b>
                    </div>
                    <b class="success text-green-500"></b>
                    <b class="errors text-red-500"></b>
                    <form action="{{ route('updateSale', $sale->id) }}" method="POST">
                        @csrf

                        <div class="w-full text-center">
                            <label for="">Type de bouteilles</label>
                            <div class="w-full flex gap-1 sub-form">
                                <div class=" ">
                                    6kg
                                    <div class="flex gap-2">
                                        <input type="number" name="prix_6" value="{{ $sale->prix_6 }}"
                                            placeholder="prix U" required>
                                        <input type="number" name="qty_6" value="{{ $sale->qty_6 }}" placeholder="qte"
                                            id="" required>
                                    </div>
                                </div>
                                <div class=" ">
                                    12.5kg

                                    <div class="flex  gap-2 ">
                                        <input type="number" name="prix_12" value="{{ $sale->prix_12 }}"
                                            placeholder="prix U" required>
                                        <input type="number" name="qty_12" value="{{ $sale->qty_12 }}" placeholder="qte"
                                            id="" required>
                                    </div>
                                </div>
                                <div class=" ">
                                    50 kg

                                    <div class="flex  gap-2 ">
                                        <input type="number" name="prix_50" value="{{ $sale->prix_50 }}"
                                            placeholder="prix U" required>
                                        <input type="number" name="qty_50" value="{{ $sale->qty_50 }}" placeholder="qte"
                                            id="" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-champs">
                            <label for="">Nom Client</label>
                            <input type="text" name="costumer" value="{{ $sale->customer }}" required>
                            @if ($errors->has('costumer'))
                                <b class="text-red-500">{{ $errors->first('costumer') }}</b>
                            @endif
                        </div>
                        <div class="modal-champs">
                            <label for="">Numero Client</label>
                            <input type="number" name="numero" value="{{ $sale->number }}" required>
                            @if ($errors->has('numero'))
                                <b class="text-red-500">{{ $errors->first('numero') }}</b>
                            @endif
                        </div>
                        <div class="modal-champs">
                            <label for="">Adresse du client :</label>
                            <input type="text" name="address" value="{{ $sale->address }}" id="unit_price" required>
                            @if ($errors->has('text'))
                                <b class="text-red-500">{{ $errors->first('text') }}</b>
                            @endif
                        </div>

                        <div class="modal-champs">
                            <label for="">Type de Paiement</label>
                            <select name="currency">
                                <object data="{{ $sale->currency }}" type="">{{ $sale->currency }}</object>
                                <option value="cash">Cash</option>
                                <option value="virement">Virement</option>
                            </select>
                            @if ($errors->has('currency'))
                                <b class="text-red-500">{{ $errors->first('currency') }}</b>
                            @endif
                        </div>
                        <div class="modal-champs">
                            <h2>Montant : <b></b></h2>
                        </div>
                        <div class="modal-validation">
                            <button type="reset">annuler</button>
                            <button type="submit" id="submitForm">modifier</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    @endsection
