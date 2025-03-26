@extends('Layouts.DirectionLayout')
@section('content')
    <div id="pdf-form" class="">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF des versements</h1>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('caGLobalPDF') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Region</label>
                        <select name="region" id="">

                            <option value="global">Global</option>
                            @foreach ($region as $reg)
                                <option value="{{ $reg->region }}">{{ $reg->region }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('region'))
                            <span class="text-red-500">{{ $errors->first('region') }}</span>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Type</label>
                        <select name="type" id="">

                            <option value="consigne">Consigne</option>
                            <option value="gpl">GPL</option>
                        </select>
                        @if ($errors->has('type'))
                            <span class="text-red-500">{{ $errors->first('type') }}</span>
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
@endsection
