@extends("Layouts.appLayout")
@section('content')
<center>
    <h1 class="text-xl font-bold">Ajouter un nouveau Role</h1>
    <form action="{{route('store-role')}}" method="post" class="md:w-4/12 border-2 mt-2 p-5 border-blue-400 rounded-md">
        @csrf
        <div class="champs">
            <label for="username">Nom:</label>
            <input type="text" name="role" required>
            @if ($errors->has("role"))
                <p class="text-red-500"> {{$errors->first('role')}}</p>
            @endif
        </div>
        </div>
        <div class="w-full flex justify-between mt-4">
            <button type="reset" class="p-2 bg-black text-white">Annuler</button>
            <button type="submit" class="p-2 bg-blue-400 text-white">Enregistrer</button>
        </div>
    </form>
</center>
@endsection