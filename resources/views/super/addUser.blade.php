@extends('Layouts.appLayout')
@section('content')
    <center>
        <h1 class="text-xl font-bold">Ajouter un nouvelle utilisateur</h1>
        <form action="{{ route('addUser') }}" method="post" class="md:w-4/12 border-2 mt-2 p-5 border-blue-400 rounded-md">
            @csrf
            <div class="champs">
                <label for="username">Nom:</label>
                <input type="text" name="name" required>
                @if ($errors->has('name'))
                    <p class="text-red-500"> {{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="champs">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                @if ($errors->has('email'))
                    <p class="text-red-500"> {{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="champs">
                <label for="password">Mot de Passe:</label>
                <input type="password" name="password" required>

                @if ($errors->has('password'))
                    <p class="text-red-500"> {{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="champs">
                <label for="password">Confirmer Mot de Passe:</label>
                <input type="password" name="password_confirmation" required>

                @if ($errors->has('password_confirmation'))
                    <p class="text-red-500"> {{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>
            <div class="w-full text-start">
                <label for="">Region:</label>
                <select name="region" id="" class="w-full text-center p-2 mt-2 mb-2">
                    @foreach ($regions as $region)
                        <option value="{{ $region->region }}">{{ $region->region }}</option>
                    @endforeach
                    <option value="all">ALL(direction only)</option>
                </select>
            </div>
            <div class="w-full text-start">
                <label for="">Role:</label>
                <select name="role" id="" class="w-full text-center p-2 mt-2 mb-2">
                    @foreach ($roles as $role)
                        <option value="{{ $role->role }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full flex justify-between mt-4">
                <button type="reset" class="p-2 bg-black text-white">Annuler</button>
                <button type="submit" class="p-2 bg-blue-400 text-white">Enregistrer</button>
            </div>
        </form>
    </center>
@endsection
