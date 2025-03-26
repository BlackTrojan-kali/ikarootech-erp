@extends('Layouts.appLayout')
@section('content')
    <div class="w-full">
        <center>

            <div class="w-6/12 border-2 border-gray-300">
                <div class="modal-head">
                    <h1>Creer une nouvelle categorie client</h1>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" class="p-2" action="{{ route('update-client-cat', ['id' => $clientCat->id]) }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Nom:</label>
                        <input type="text" value="{{ $clientCat->name }}" name="name">
                        @if ($errors->has('name'))
                            <b class="text-red-500">{{ $errors->first('name') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Reduction:</label>
                        <input type="number" value="{{ $clientCat->reduction }}" name="redux">
                        @if ($errors->has('redux'))
                            <b class="text-red-500">{{ $errors->first('redux') }}</b>
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
