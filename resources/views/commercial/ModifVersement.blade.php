@extends('Layouts.comLayout')
@section('content')
    <!--FORMULAIRE DE VERSEMENTS-->
    <div>
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Modifier un Versement</h1>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('updateVersement', $versement->id) }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Montant GPL:</label>
                        <input type="number" name="montant_gpl" value="{{ $versement->montant_gpl }}" required>
                        @if ($errors->has('montant_gpl'))
                            <b class="text-red-500">{{ $errors->first('montant_gpl') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Montant Consigne:</label>
                        <input type="number" name="montant_consigne" value="{{ $versement->montant_consigne }}" required>
                        @if ($errors->has('montant_consigne'))
                            <b class="text-red-500">{{ $errors->first('montant_consigne') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Banque:</label>
                        <select name="bank" id="">
                            <option value="{{ $versement->bank }}"> {{ $versement->bank }}</option>
                            <option value="AFB">AFB</option>
                            <option value="CCA">CCA</option>
                        </select>
                        @if ($errors->has('bank'))
                            <b class="text-red-500">{{ $errors->first('bank') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero de Bordereau:</label>
                        <input type="text" name="bordereau" value="{{ $versement->bordereau }}" required>
                    </div>
                    <div class="modal-champs">
                        <label for="">Commentaire:</label>
                        <input type="text" name="commentaire" value="{{ $versement->commentaire }}">
                        @if ($errors->has('commentaire'))
                            <b class="text-red-500">{{ $errors->first('commentaire') }}</b>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">modifier</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>
@endsection
