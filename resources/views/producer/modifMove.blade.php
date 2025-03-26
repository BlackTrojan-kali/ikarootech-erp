@extends('Layouts.producerLayout')
@section('content')
    <div>
        <center>

            <div class="modal-active">
                <div class="bg-gray-700 text-white p-2 rounded-sm font-bold text-center">
                    <h1>Modifier mouvement</h1>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form action="{{ route('update-move-pro', $move->id) }}" method="post">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">

                            <option value="{{ $move->origin }}">{{ $move->origin }}</option>
                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            @if (Auth::user()->region == 'central')
                                <option value="achat">achat</option>
                            @endif
                            <option value="region">region</option>
                            <option value="production">production</option>
                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('origin'))
                            <span class="text-red-500">{{ $errors->first('origin') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite : </label>
                        <input type="number" name="qty" value="{{ $move->qty }}" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" value="{{ $move->label }}" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" value="{{ $move->bordereau }}" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite du stock : </label>
                        <input type="number" name="stock_qty" value="{{ $move->stock }}" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('stock_qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">Modifier</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>
@endsection
