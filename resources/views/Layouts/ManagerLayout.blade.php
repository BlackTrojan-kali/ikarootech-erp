<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('COMPANIE_NAME') }} SCsMS</title>
    <link rel="icon" href="/images/logo.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="toastr.css" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>

<body class="px-30">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    @if (session('success'))
        <script type="module">
            $(document).ready(function() {
                toastr.success("{{ session('success') }}")
            })
        </script>
    @elseif ($errors->has('message'))
        <script type="module">
            $(document).ready(function() {
                toastr.error("{{ $errors->first('message') }}")
            })
        </script>
    @endif
    <header class="p-4 text-sm  md:text-base ">
        <div class="w-full flex justify-between">
            <img src="/images/logo.png" class="w-28 md:w-32 h-auto" alt="">
            <div class="text-center mt-2">
                <p>
                    <i class="fa-solid fa-user"></i>
                    {{ Auth::user()->email }}
                </p>
                <h2 class="text-large">{{ env('COMPANIE_NAME') }} Supply Chain Management System</h2>
                <h2 class="text-large">
                    Region: {{ strtoupper(Auth::user()->region) }}
                </h2>
                <h2 class="text-large">
                    Service: {{ Auth::user()->role }}
                </h2>
            </div>
            <div class=" mt-10 cursor-pointer text-center">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit">
                        <i class="fa    -solid fa-right-from-bracket text-red-800 text-4xl"></i>
                        <p> deconnexion</p>
                    </button>
                </form>
            </div>
        </div>

        <nav class="mt-2 p-2 w-full text-white flex flex-col md:flex-row gap-4   primary rounded-md">

            <div><a href="{{ route('dashboard-manager') }}"><i class="fa-solid fa-home"></i> ACCEUIL</a></div>
            <div class="font-bold cursor-pointer dropdown relative">MOUVEMENTS <i class="fa-solid fa-angle-down"></i>
                <div class="drop-items">
                    <div class="drop-2 elem">
                        Entree
                        <ul class="drop-items-2">
                            <li class="elem" id="activate-form-entry-gpl"><a>GPL Vrac</a></li>
                            <li class="elem" id="activate-transmit-form"><a>Tranfert Vrac</a></li>
                            <li class="elem" id="activate-form-entry-vide"><a>Bouteilles Vides</a></li>
                            <li class="elem" id="activate-form-entry-pleine"><a>Bouteilles Pleines</a></li>
                            <li class="elem" id="activate-form-entry-accessory"><a>Accessoires</a></li>
                        </ul>
                    </div>
                    <div class="drop-2 elem">
                        Sortie


                        <ul class="drop-items-2">
                            <!-- <li class="elem " id="activate-form-outcome-gpl"><a href="">GPL Vrac (sortie)</a></li> -->
                            <li class="elem" id="activate-form-outcome-vide"><a>Bouteilles Vides(sortie)</a></li>
                            <li class="elem" id="activate-form-outcome-pleine"><a>Bouteilles Pleines(sortie)</a>
                            </li>
                            <li class="elem" id="activate-form-outcome-accessory"><a>Accessoires(sortie)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div><a href="{{ route('showCiterneMan') }}">CITERNES</a></div>
            <!--  <div> <a href="{{ route('manager-histories') }}">HISTORIQUE</a></div> -->
            <div> <a href="{{ route('showReleve') }}">RECEPTION</a></div>

            <div class="dropdown cursor-pointer font-bold relative"> ETATS <i class="fa-solid fa-angle-down"></i>
                <div class="drop-items">
                    <div class="drop-2 elem">
                        MOUVEMENTS ENTREES
                        <ul class="drop-items-2">
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 1, 'weight' => 6]) }}">6
                                    KG</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 1, 'weight' => 12.5]) }}">12.5
                                    KG</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 1, 'weight' => 50]) }}"> 50
                                    KG</a>
                            </li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 1, 'weight' => 0]) }}">ACCESSOIRES</a>
                            </li>
                        </ul>
                    </div>

                    <div class="drop-2 elem">
                        MOUVEMENTS Sortie
                        <ul class="drop-items-2">
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 0, 'weight' => 6]) }}">6 KG
                                    (sortie)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 0, 'weight' => 12.5]) }}">12.5
                                    KG
                                    (sortie)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 0, 'weight' => 50]) }}">50
                                    KG
                                    (sortie)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 0, 'weight' => 0]) }}">ACCESSOIRES
                                    (sortie)</a></li>

                        </ul>
                    </div>

                    <div class="drop-2 elem">
                        MOUVEMENTS Global
                        <ul class="drop-items-2">
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'bouteille-gaz', 'weight' => 6]) }}">6
                                    KG
                                    (global)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'bouteille-gaz', 'weight' => 12.5]) }}">12.5
                                    KG (global)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'bouteille-gaz', 'weight' => 50]) }}">50
                                    KG
                                    (global)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'accessoire', 'weight' => 0]) }}">ACCESSOIRES
                                    (global)</a></li>

                        </ul>
                    </div>
                    <div class="text-center elem"><a href="{{ route('historique-rel') }}">Etats Releves</a></div>
                    <div class="text-center elem"><a href="{{ route('broutes-list-man') }}">Bordereaux de Route</a>
                    </div>
                </div>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">GENERER UN DOCUMENT<i
                    class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem" id="activate-pdf-form">Etats des mouvements</li>
                    <li class="elem" id="activate-receives-pdf-form">historique des reception</li>
                    <li class="elem" id="activate-releves-pdf-form">historique des releves</li>
                    <li class="elem" id="activate-broute-pdf-form">bordereau de route</li>
                </ul>
            </div>
        </nav>

    </header>
    <div class="w-full overflow-x-scroll  md:overflow-x-hidden">
        @yield('content')
    </div>
    <br><br><br><br><br><br><br><br>

    <!--FORMULAIRE DE GENERATION DE PDF RElEVEES-->
    <div id="releves-pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF RELEVES</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('releves_pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart" required>
                        @if ($errors->has('depart'))
                            <span class="text-red-500">{{ $errors->first('depart') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin" required>
                        @if ($errors->has('fin'))
                            <span class="text-red-500">{{ $errors->first('fin') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Citerne</label>
                        <select name="citerne" id="">
                            @foreach ($fixe as $fix)
                                <option value="{{ $fix->name }}">{{ $fix->name }}</option>
                            @endforeach
                            <option value="global"> Global</option>
                        </select>
                        @if ($errors->has('citerne'))
                            <span class="text-red-500">{{ $errors->first('citerne') }}</span>
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

    <!--FORMULAIRE DE GENERATION DE PDF RECEPTIONS-->
    <div id="recieves-pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF RECEPTIONS</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('receives_pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart" required>
                        @if ($errors->has('depart'))
                            <span class="text-red-500">{{ $errors->first('depart') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin" required>
                        @if ($errors->has('fin'))
                            <span class="text-red-500">{{ $errors->first('fin') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Citerne</label>
                        <select name="citerne" id="">
                            @foreach ($mobile as $fix)
                                <option value="{{ $fix->id }}">{{ $fix->name }}</option>
                            @endforeach
                            <option value="global"> Global</option>
                        </select>
                        @if ($errors->has('citerne'))
                            <span class="text-red-500">{{ $errors->first('citerne') }}</span>
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
    <!--FORMULAIRE DE GENERATION DE PDF-->
    <div id="pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart" required>
                        @if ($errors->has('depart'))
                            <span class="text-red-500">{{ $errors->first('depart') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin" required>
                        @if ($errors->has('fin'))
                            <span class="text-red-500">{{ $errors->first('fin') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">etat :</label><br>

                        <input type="radio" value="1" name="state"> pleine
                        <input type="radio" value="0" name="state">vide
                        <input type="radio" value="777" name="state">accessoire
                    </div>
                    @if ($errors->has('state'))
                        <span class="text-red-500">{{ $errors->first('state') }}</span>
                    @endif
                    <div class="modal-champs">
                        <label for="">Type de Movement</label>
                        <select name="move" id="">

                            <option value="1">entree</option>
                            <option value="0">sortie</option>
                            <option value="777">Global</option>

                        </select>
                        @if ($errors->has('move'))
                            <span class="text-red-500">{{ $errors->first('move') }}</span>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Service</label>
                        <select name="service" id="">

                            <option value="{{ Auth::user()->role }}">{{ Auth::user()->role }}</option>

                        </select>
                        @if ($errors->has('service'))
                            <span class="text-red-500">{{ $errors->first('service') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type de bouteille</label>
                        <select name="type" id="">

                            <option value="50">50KG</option>
                            <option value="12.5">12.5KG</option>
                            <option value="6">6KG</option>
                            <option value="777">accessiore</option>

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
    <!-- FORMULAIRE DE GENERATION DU BORDEREAU DE ROUTE-->
    <div id="broute-form" class="modals ">
        <center class=" overflow-y-scroll">

            <div class="modal-active size-2">
                <div class="modal-head">
                    <h1>Generer un Bordereau de route</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('gen-broute') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Immatriculation du vehicule</label>
                        <input type="text" required name="matricule">
                        @if ($errors->has('matricule'))
                            <span class="text-red-500">{{ $errors->first('matricule') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Ville de depart</label>
                        <input type="text" required name="depart">
                        @if ($errors->has('depart'))
                            <span class="text-red-500">{{ $errors->first('depart') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Ville d'arrivee</label>
                        <input type="text" required name="arrivee">
                        @if ($errors->has('arrivee'))
                            <span class="text-red-500">{{ $errors->first('arrivee') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Date depart:</label>
                        <input type="date" name="date_depart" required>
                        @if ($errors->has('date_depart'))
                            <span class="text-red-500">{{ $errors->first('date_depart') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Date Arrivee:</label>
                        <input type="date" name="date_arrivee">
                        @if ($errors->has('date_arrivee'))
                            <span class="text-red-500">{{ $errors->first('date_arrivee') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Nom chauffeur :</label><br>

                        <input type="text" name="nom_chauffeur" required>
                    </div>
                    @if ($errors->has('nom_chauffeur'))
                        <span class="text-red-500">{{ $errors->first('nom_chauffeur') }}</span>
                    @endif
                    <div class="modal-champs">
                        <label for="">Permis</label>
                        <input type="text" name="permis" required />
                        @if ($errors->has('permis'))
                            <span class="text-red-500">{{ $errors->first('permis') }}</span>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Aide Chauffeur</label>
                        <input type="text" name="aide_chauffeur">


                        @if ($errors->has('aide_chauffeur'))
                            <span class="text-red-500">{{ $errors->first('aide_chauffeur') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Contacts</label>
                        <input type="text" name="contact" required />
                        @if ($errors->has('contact'))
                            <span class="text-red-500">{{ $errors->first('contact') }}</span>
                        @endif
                    </div>

                    <div class="modal-champs">

                        <label for="">Details:</label>
                        <textarea name="details" class="w-full border-2 border-gray-200" required>
                        </textarea>
                        @if ($errors->has('details'))
                            <span class="text-red-500">{{ $errors->first('details') }}</span>
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
    <!--TRANSFERT GPL VRAC -->

    <div id="transmit-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Depotage GPL Vrac</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="transmit-gpl-form" method="POST" action="{{ route('Depotage') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Citerne Mobile:</label>
                        <select name="mobile" id="">
                            @foreach ($vrac as $vra)
                                <option value="{{ $vra->id }} }}">{{ $vra->name }}-({{ $vra->type }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('mobile'))
                            <span class="text-red-500">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Citerne Fixe:</label>
                        <select name="fixe" id="">
                            @foreach ($fixe as $fix)
                                <option value="{{ $fix->id }}">{{ $fix->name }}-({{ $fix->type }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('fixe'))
                            <span class="text-red-500">{{ $errors->first('fixe') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite : </label>
                        <input type="number" name="qty" required>
                    </div>
                    @if ($errors->has('qty'))
                        <span class="text-red-500">{{ $errors->first('qty') }}</span>
                    @endif
                    <div class="modal-champs">
                        <label for="">Matricule du Vehicule </label>
                        <input type="text" name="matricule" required>
                        @if ($errors->has('matricule'))
                            <span class="text-red-500">{{ $errors->first('matricule') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>

    <!--ENTREE FORMULAIRES-->
    <div id="entry-gpl" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de GPL Vrac</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500 "></span>
                <span class="errors text-red-500 "></span>
                <form id="entry-gpl-form" method="POST" action="{{ route('MoveGpl') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type de citerne:</label>
                        <select name="citerne" id="">
                            @foreach ($vrac as $vra)
                                <option value="{{ $vra->name }}">{{ $vra->name }} - ({{ $vra->type }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('citerne'))
                            <span class="text-red-500">{{ $errors->first('citerne') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite en KG </label>
                        <input type="number" name="qty" required>

                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Provenance</label>
                        <input type="text" name="provenance" required>

                        @if ($errors->has('provenance'))
                            <span class="text-red-500">{{ $errors->first('provenance') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero Bordereau Livraison: </label>
                        <input type="text" name="livraison" required>
                        @if ($errors->has('livraison'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Matricule du vehicule : </label>
                        <input type="text" name="matricule" required>
                        @if ($errors->has('matricule'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>

    <div id="entry-pleine" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de Bouteilles Pleines</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500 "></span>
                <span class="errors text-red-500 "></span>
                <form id="entry-pleine-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
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
                        <label for="">Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight"> 6kg
                            <input type="radio" value="12.5" name="weight">12.5kg
                            <input type="radio" value="50" name="weight">50 kg
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite :</label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle</label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>


    <div id="entry-vides" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de Bouteilles Vides</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="entry-vides-form"
                    action="{{ route('saveBottleMove', ['action' => 'entry', 'state' => 0]) }}" method="post">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            @if (Auth::user()->region != 'central')
                                <option value="achat">Fournisseur</option>
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            @if (Auth::user()->region == 'central')
                                <option value="achat">achat</option>
                                <option value="retour reepreuve">Retour sur reepreuve</option>
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
                        <label for="">Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight"> 6kg
                            <input type="radio" value="12.5" name="weight">12.5kg
                            <input type="radio" value="50" name="weight">50 kg
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite : </label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>


    <div id="entry-accessory" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de Accessoire</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="entry-accessory-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'accessiore:</label>
                        <select name="title" id="">
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->title }}">{{ $accessory->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('title'))
                            <span class="text-red-500">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="operation" id="">

                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('operation'))
                            <span class="text-red-500">{{ $errors->first('operation') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite : </label>
                        <input type="number" name="qty" required>
                    </div>
                    @if ($errors->has('qty'))
                        <span class="text-red-500">{{ $errors->first('qty') }}</span>
                    @endif
                    <div class="modal-champs">
                        <label for="">Libelle</label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau : </label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>

    <!--SORTIES FORMULAIRES-->

    <div id="outcome-gpl" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Outcome de GPL Vrac</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500 "></span>
                <span class="errors text-red-500 "></span>
                <form id="outcome-gpl-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type de citerne:</label>
                        <select name="citerne" id="">
                            @foreach ($vrac as $vrac)
                                <option value="{{ $vrac->name }}">{{ $vrac->name }}-({{ $vrac->type }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('citerne'))
                            <span class="text-red-500">{{ $errors->first('citerne') }}</span>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="operation" id="">

                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('operation'))
                            <span class="text-red-500">{{ $errors->first('operation') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite <span class="text-red-500">*</span></label>
                        <div>
                            <input type="number" name="qty" required>

                            @if ($errors->has('qty'))
                                <span class="text-red-500">{{ $errors->first('qty') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>

    <div id="outcome-pleine" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Bouteilles Pleines</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="outcome-pleine-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            <option value="region">region</option>
                            <option value="pertes">Pertes</option>
                            @if (Auth::user()->region != 'central')
                                <option value="magasin central">MAGASIN CENTRAL</option>
                                <option value="client">Client</option>
                            @endif
                        </select>
                        @if ($errors->has('origin'))
                            <span class="text-red-500">{{ $errors->first('origin') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight"> 6kg
                            <input type="radio" value="12.5" name="weight">12.5kg
                            <input type="radio" value="50" name="weight">50 kg
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite : </label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>



    <div id="outcome-vides" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Bouteilles Vides</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="outcome-vides-form"
                    action="{{ route('saveBottleMove', ['action' => 'outcome', 'state' => 0]) }}" method="POST">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            @if (Auth::user()->region != 'central')
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="production">Production</option>
                            <option value="reepreuve">Reepreuve</option>
                            <option value="consigne">Consigne</option>
                            <option value="pertes">Pertes</option>
                        </select>
                        @if ($errors->has('origin'))
                            <span class="text-red-500">{{ $errors->first('origin') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight"> 6kg
                            <input type="radio" value="12.5" name="weight">12.5kg
                            <input type="radio" value="50" name="weight">50 kg
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite : </label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>


    <div id="outcome-accessory" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Accessoire</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="outcome-accessory-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="title" id="">
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->title }}">{{ $accessory->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('title'))
                            <span class="text-red-500">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Type d'accessiore:</label>
                        <select name="operation" id="">

                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('operation'))
                            <span class="text-red-500">{{ $errors->first('operation') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite :</label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <span class="text-red-500">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <span class="text-red-500">{{ $errors->first('label') }}</span>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <span class="text-red-500">{{ $errors->first('bord') }}</span>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                    <div id="loading" style="display:none;" class=" text-yellow-500">enregistrement...
                    </div>
                </form>
            </div>
        </center>
    </div>



    <footer class="mt-10 w-full secondary flex justify-between p-4 text-white rounded-md">
        <div>
            <a href="">Contacter</a>
            <a href="">Aide</a>
            <a href="">Mention Legal</a>
        </div>
        <p>&copy; 2024</p>
    </footer>


    <script type="module">
        //TRANSMIT FORM

        $('table').DataTable();
        $("#activate-transmit-form").on("click", function(e) {
            e.preventDefault()
            if ($("#transmit-form").hasClass("modals")) {
                $("#transmit-form").addClass("modals-active");
                $("#transmit-form").removeClass("modals");
            }

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#transmit-form").hasClass("modals-active")) {
                    $("#transmit-form").addClass("modals");
                    $("#transmit-form").removeClass("modals-active");
                }
            })
        })


        //form deployment
        $(function() {
            //ACTION generate broute form 
            $("#activate-broute-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#broute-form").hasClass("modals")) {
                    $("#broute-form").addClass("modals-active")

                    $("#broute-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#broute-form").hasClass("modals-active")) {
                    $("#broute-form").addClass("modals")
                    $("#broute-form").removeClass("modals-active")
                }
            })
            //ACTION generate pdf releves 
            $("#activate-releves-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#releves-pdf-form").hasClass("modals")) {
                    $("#releves-pdf-form").addClass("modals-active")

                    $("#releves-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#releves-pdf-form").hasClass("modals-active")) {
                    $("#releves-pdf-form").addClass("modals")
                    $("#releves-pdf-form").removeClass("modals-active")
                }
            })

            //ACTION generate pdf receives 
            $("#activate-receives-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#recieves-pdf-form").hasClass("modals")) {
                    $("#recieves-pdf-form").addClass("modals-active")

                    $("#recieves-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#recieves-pdf-form").hasClass("modals-active")) {
                    $("#recieves-pdf-form").addClass("modals")
                    $("#recieves-pdf-form").removeClass("modals-active")
                }
            })

            //ACTIon GENERATE PDF
            $("#activate-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#pdf-form").hasClass("modals")) {
                    $("#pdf-form").addClass("modals-active");
                    $("#pdf-form").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#pdf-form").hasClass("modals-active")) {
                        $("#pdf-form").addClass("modals");
                        $("#pdf-form").removeClass("modals-active");
                    }
                })
            })
            //ACTION ENTRY ON MODAL GPL
            $("#activate-form-entry-gpl").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-gpl").hasClass("modals")) {
                    $("#entry-gpl").addClass("modals-active");
                    $("#entry-gpl").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#entry-gpl").hasClass("modals-active")) {
                        $("#entry-gpl").addClass("modals");
                        $("#entry-gpl").removeClass("modals-active");
                    }
                })
            })
            //ACTION ENTRY ON MODAL BOUTEILLES-VIDES
            $("#activate-form-entry-vide").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-vides").hasClass("modals")) {
                    $("#entry-vides").addClass("modals-active")

                    $("#entry-vides").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-vides").hasClass("modals-active")) {
                    $("#entry-vides").addClass("modals")
                    $("#entry-vides").removeClass("modals-active")
                }
            })

            //ACTION ENTRY ON MODAL BOUTEILLES-PLEINES
            $("#activate-form-entry-pleine").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-pleine").hasClass("modals")) {
                    $("#entry-pleine").addClass("modals-active")

                    $("#entry-pleine").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-pleine").hasClass("modals-active")) {
                    $("#entry-pleine").addClass("modals")
                    $("#entry-pleine").removeClass("modals-active")
                }
            })

            //ACTION ENTRY ON MODAL BOUTEILLES-PLEINES
            $("#activate-form-entry-accessory").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-accessory").hasClass("modals")) {
                    $("#entry-accessory").addClass("modals-active")

                    $("#entry-accessory").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#entry-accessory").hasClass("modals-active")) {
                    $("#entry-accessory").addClass("modals")
                    $("#entry-accessory").removeClass("modals-active")
                }
            })

            //ACTION OUTCOME ON MODAL BOUTEILLES-VIDES
            $("#activate-form-outcome-gpl").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-gpl").hasClass("modals")) {
                    $("#outcome-gpl").addClass("modals-active");
                    $("#outcome-gpl").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#outcome-gpl").hasClass("modals-active")) {
                        $("#outcome-gpl").addClass("modals");
                        $("#outcome-gpl").removeClass("modals-active");
                    }
                })
            })
            //ACTION OUTCOME ON MODAL BOUTEILLES-VIDES
            $("#activate-form-outcome-vide").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-vides").hasClass("modals")) {
                    $("#outcome-vides").addClass("modals-active")

                    $("#outcome-vides").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-vides").hasClass("modals-active")) {
                    $("#outcome-vides").addClass("modals")
                    $("#outcome-vides").removeClass("modals-active")
                }
            })

            //ACTION OUTCOME ON MODAL BOUTEILLES-PLEINES
            $("#activate-form-outcome-pleine").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-pleine").hasClass("modals")) {
                    $("#outcome-pleine").addClass("modals-active")

                    $("#outcome-pleine").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-pleine").hasClass("modals-active")) {
                    $("#outcome-pleine").addClass("modals")
                    $("#outcome-pleine").removeClass("modals-active")
                }
            })

            //ACTION OUTCOME ON MODAL BOUTEILLES-PLEINES
            $("#activate-form-outcome-accessory").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-accessory").hasClass("modals")) {
                    $("#outcome-accessory").addClass("modals-active")

                    $("#outcome-accessory").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#outcome-accessory").hasClass("modals-active")) {
                    $("#outcome-accessory").addClass("modals")
                    $("#outcome-accessory").removeClass("modals-active")
                }
            })

            //VALIDATION DES FORMULAIRES   $("#entry-gpl-form").submit(function(e){

            //FORMULAIRE ENTREES GPL
            $("#entry-gpl-form").submit(function(e) {
                e.preventDefault();
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('MoveGpl') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $(".success").text(response.success);
                        $("#submitForm").prop("disabled", false);
                        $('#loading').hide();
                        setTimeout(() => {
                            $(".success").text("");

                        }, 1500);
                        $("#entry-gpl-form")[0].reset();
                        $(".text-red-500").load(location.href + " .text-red-500")
                        $("table").load(location.href + " table")
                        $(".info").load(location.href + " .info")
                    }
                })

            })
            //FORMULAIRE ENTREES BOUTIELLES PLEINES
            $("#entry-pleine-form").submit(function(e) {
                e.preventDefault()
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);

                $('#loading').show();
                $.ajax({
                    url: "{{ route('saveBottleMove', ['action' => 'entry', 'state' => 1]) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $(".errors").text(response.error);

                            $("#submitForm").prop("disabled", false);

                            $('#loading').hide();
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                            $("#entry-pleine-form")[0].reset();
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#entry-pleine-form")[0].reset();
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    }
                })
            })

            //VALIDATION FORMULAIRE ENTREES BOUTEILLES VIDES
            $("#entry-vides-form").submit(function(e) {
                e.preventDefault()
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);

                $('#loading').show();
                $.ajax({
                    url: "{{ route('saveBottleMove', ['action' => 'entry', 'state' => 0]) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $(".errors").text(response.error);
                            $("#submitForm").prop("disabled", false);

                            $('#loading').hide();
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                            $("#entry-vides-form")[0].reset();
                        } else {
                            $(".success").text(response.success);
                            $("#submitForm").prop("disabled", false);

                            $('#loading').hide();
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $(".errors").text("");
                            $("#entry-vides-form")[0].reset();
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#submitForm").prop("disabled", false);

                        console.log(xhr)
                        console.log(error)
                    }

                })
            })
            //VALIDATION FORMULAIRE ENTREE ACCESSOIRES
            $("#entry-accessory-form").submit(function(e) {
                e.preventDefault();
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('saveAccessoryMove', ['action' => 'entry']) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $(".errors").text(response.error);
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#entry-accessory-form")[0].reset()
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#submitForm").prop("disabled", false);
                        console.log(xhr);
                        console.log(error)
                    }
                })
            })
            //VALIDATION DU TRANFERT DE GPL VRAC 
            $("#transmit-gpl-form").submit(function(e) {
                e.preventDefault();
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('Depotage') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $(".errors").text(response.error);
                            $("#submitForm").prop("disabled", false);
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                            $("#transmit-gpl-form")[0].reset()
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);

                            $('#loading').hide();
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#transmit-gpl-form")[0].reset()
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    }
                })
            })
            // VALIDATION DE FORMULAIRE SORTIE BOUTEILLES PLEINES
            $("#outcome-pleine-form").submit(function(e) {
                e.preventDefault()
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('saveBottleMove', ['action' => 'outcome', 'state' => 1]) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $(".errors").text(response.error);
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                            $("#outcome-pleine-form")[0].reset()
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            $(".success").text(response.success)
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#outcome-pleine-form")[0].reset()
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    }
                })
            })
            //VALIDATION DE FORMULAIRE SORTIE BOUTIELLES VIDE
            $("#outcome-vides-form").submit(function(e) {
                e.preventDefault()
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('saveBottleMove', ['action' => 'outcome', 'state' => 0]) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {
                            $(".errors").text(response.error);
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                            $("#outcome-vides-form")[0].reset()
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#outcome-vides-form")[0].reset()
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    }
                })
            })
            //VALIDATION FORMULAIRE SORTIE ACCESSOIRES
            $("#outcome-accessory-form").submit(function(e) {
                e.preventDefault()
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('saveAccessoryMove', ['action' => 'outcome']) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.error) {

                            $(".errors").text(response.error);

                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            setTimeout(() => {
                                $(".errors").text("");

                            }, 1500);
                            $(".success").text("");
                            $("#outcome-accessory-form")[0].reset();
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#outcome-accessory-form")[0].reset();
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>
