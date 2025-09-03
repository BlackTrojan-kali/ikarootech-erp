<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('COMPANIE_NAME') }} SMS - Login</title>
    <link rel="icon" href="/images/logo.png">
    @vite(['resources/css/app.css'])

    {{-- Liens CSS pour Toastr --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="secondary flex items-center justify-center min-h-screen p-4">

    <main class="w-full max-w-md mx-auto"> {{-- Utilisation de main pour le contenu principal et centrage avec Tailwind --}}

        {{-- Section du logo et du titre --}}
        <div class="bg-black/10 p-4 md:px-8 md:py-4 flex justify-between items-center rounded-t-md">
            <div class="rounded-md">
                <center>
                <img src="/images/logo.png" class="w-24" alt="Logo de {{ env('COMPANIE_NAME') }}" aria-label="Logo de l'entreprise">
                </center>
            </div>
        </div>

        {{-- Boîte de bienvenue --}}
        <div class="box p-4 rounded-b-md font-bold text-center general bg-white shadow-md shadow-white/60 mb-8">
            <h2>Bienvenue sur {{ env('COMPANIE_NAME') }} Supply Chain Management System</h2>
        </div>

        {{-- Formulaire de connexion --}}
        <div class="bg-white rounded-md p-6 shadow-lg"> {{-- Ajout de p-6 pour plus d'espace, shadow-lg pour une meilleure visibilité --}}
            <form action="{{ route('authenticate') }}" method="post">
                @csrf
                <div class="champs mb-4"> {{-- Ajout de mb-4 pour l'espacement --}}
                    <label for="email_login">Login:</label> {{-- Ajout de 'for' pour l'accessibilité --}}
                    <input type="email" id="email_login" name="email" class="w-full h-9 mt-2 bg-gray-400/25 p-2 mb-2 rounded-md" aria-label="Votre adresse e-mail">
                    @error('email') {{-- Utilisation de la directive @error de Blade pour une meilleure gestion des erreurs --}}
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="champs mb-6"> {{-- Ajout de mb-6 pour l'espacement --}}
                    <label for="password_login">Mot de passe:</label> {{-- Ajout de 'for' pour l'accessibilité --}}
                    <input type="password" id="password_login" name="password" class="w-full h-9 mt-2 bg-gray-400/25 p-2 mb-2 rounded-md" aria-label="Votre mot de passe">
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="mt-4 primary p-3 w-full rounded-md text-white font-semibold hover:opacity-90 transition-opacity">S'identifier</button> {{-- Ajustement de p-2 à p-3, ajout de font-semibold et hover effect --}}
            </form>
        </div>
<br><br><br>
    </main>

    {{-- Pied de page --}}
    <footer class="w-full absolute bottom-0 left-0 ternary text-white p-4 text-end">
        <p>&copy; Tous droits réservés à {{ env('COMPANIE_NAME') }}</p>
    </footer>

    {{-- Scripts JS pour jQuery et Toastr (placés à la fin du body pour de meilleures performances) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    {{-- Script pour afficher les notifications Toastr --}}
    @if ($errors->has('warning'))
        <script>
            $(document).ready(function() {
                toastr.warning("{{ $errors->first('warning') }}", "Avertissement")
            })
        </script>
    @elseif (session('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}", "Succès")
            })
        </script>
    @elseif (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}", "Erreur")
            })
        </script>
    @endif
</body>

</html>
