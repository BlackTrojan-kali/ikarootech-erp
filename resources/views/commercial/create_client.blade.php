@extends("Layouts.comLayout")
@section('content')
    <div class="w-full">
        <center>

            <div class="w-6/12 border-2 border-gray-300">
                <div class="modal-head">
                    <h1>Creer une nouvelle categorie client</h1>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" class="p-2" action="{{ route('store-client') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Nom:</label>
                        <input type="text" name="name">
                        @if ($errors->has('name'))
                            <b class="text-red-500">{{ $errors->first('name') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Prenom:</label>
                        <input type="text" name="fname">
                        @if ($errors->has('fname'))
                            <b class="text-red-500">{{ $errors->first('fname') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero de telephone:</label>
                        <input type="number" name="phone">
                        @if ($errors->has('phone'))
                            <b class="text-red-500">{{ $errors->first('phone') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Adresse:</label>
                        <input type="text" name="address">
                        @if ($errors->has('address'))
                            <b class="text-red-500">{{ $errors->first('address') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Email:</label>
                        <input type="email" name="email">
                        @if ($errors->has('email'))
                            <b class="text-red-500">{{ $errors->first('email') }}</b>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Registre Commerce:</label>
                        <input type="text" name="registre">
                        @if ($errors->has('registre'))
                            <b class="text-red-500">{{ $errors->first('registre') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Categorie:</label>
                        <select name="category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('email'))
                            <b class="text-red-500">{{ $errors->first('email') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Region :</label>
                        <select name="region">
                            @foreach ($regions as $region)
                                <option value="{{ $region->region }}">{{ $region->region }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('region'))
                            <b class="text-red-500">{{ $errors->first('region') }}</b>
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
