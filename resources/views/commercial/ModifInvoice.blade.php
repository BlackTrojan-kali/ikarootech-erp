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
                    <form action="{{ route('updateInvoice', $sale->id) }}" method="POST">
                        @csrf


                        <div class="modal-champs">
                            <label for="">Somme recue:</label>
                            <input type="text" value="{{ $sale->recieved }}" name="amount" value="{{ $sale->customer }}"
                                required>
                            @if ($errors->has('amount'))
                                <b class="text-red-500">{{ $errors->first('amount') }}</b>
                            @endif
                        </div>
                        <div class="modal-champs">
                            <label for="">Type de Paiement</label>
                            <select name="currency">
                                <object data="{{ $sale->currency }}" type="">{{ $sale->currency }}</object>
                                <option value="{{ $sale->currency }}">{{ $sale->currency }}</option>
                                <option value="cash">Cash</option>

                                <option value="virement">Virement</option>
                            </select>
                            @if ($errors->has('currency'))
                                <b class="text-red-500">{{ $errors->first('currency') }}</b>
                            @endif
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
