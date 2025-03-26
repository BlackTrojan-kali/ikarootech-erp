<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('COMPANIE_NAME') }} SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <img src="/images/logo.png" class="w-32 h-auto" alt="">
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
    </header>

    <nav class="mt-2 p-2 w-full text-white flex flex-col md:flex-row gap-4   primary rounded-md">
        <a href="{{ route('dashboardCom') }}"><i class="fa-solid fa-home"></i> ACCEUIL</a>

        <div class="font-bold cursor-pointer dropdown relative">GERER CLIENTS<i class="fa-solid fa-angle-down"></i>
            <ul class="drop-items">

                <!-- <li class="elem" id="activate-pdf-form">Etats des mouvements</li> -->
                <li class="elem"><a href="{{ route('list-clients') }}">CLIENTS</a></li>
                <li class="elem"><a href="{{ route('client-price') }}">PRIX CLIENTS</a></li>
            </ul>
        </div>
        <!--
        <div class="font-bold cursor-pointer dropdown relative">STOCK <i class="fa-solid fa-angle-down"></i>
            <div class="drop-items">
                <div class="drop-2 elem">
                    Entree
                    <ul class="drop-items-2">
                        <li class="elem" id="activate-form-entry-vide"><a>Bouteilles Vides</a></li>
                        <li class="elem" id="activate-form-entry-pleine"><a>Bouteilles Pleines</a></li>
                        <li class="elem" id="activate-form-entry-accessory"><a>Accessoires</a></li>
                    </ul>
                </div>
                <div class="drop-2 elem">
                    Sortie
                    <ul class="drop-items-2">
                         <li class="elem " id="activate-form-outcome-gpl"><a href="">GPL Vrac (sortie)</a></li>

                        <li class="elem" id="activate-form-outcome-vide"><a>Bouteilles Vides(sortie)</a></li>
                        <li class="elem" id="activate-form-outcome-pleine"><a>Bouteilles Pleines(sortie)</a></li>
                        <li class="elem" id="activate-form-outcome-accessory"><a>Accessoires(sortie)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    les ventes
    -->
        <a href="{{ route('cartlist') }}"> VENTE</a>

        <!--
            <div class="font-bold cursor-pointer dropdown relative">VENTES <i class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem" id="activate-form-sale-gpl">GPL</li>
                    <li class="elem" id="activate-form-consigne">Consignes</li>
                    <li class="elem" id="activate-acSales-form">Accessoires</li>
                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative" id="activate-versement-form">BANQUES
        </div>-->
        <div class="dropdown cursor-pointer font-bold"> ETATS <i class="fa-solid fa-angle-down"></i>
            <div class="drop-items">
                <!--   <div class="drop-2 elem">
                    MOUVEMENTS ENTREES
                    <ul class="drop-items-2">
                        <li class="elem" id="activate-form-entry-vide"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 1, 'weight' => 6]) }}">6 KG</a>
                        </li>
                        <li class="elem" id="activate-form-entry-gpl"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 1, 'weight' => 12.5]) }}">12.5
                                KG</a>
                        </li>
                        <li class="elem" id="activate-form-entry-accessory"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 1, 'weight' => 50]) }}"> 50
                                KG</a></li>
                        <li class="elem" id="activate-form-entry-vide"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 1, 'weight' => 0]) }}">ACCESSOIRES</a>
                        </li>

                    </ul>
                </div>-->
                <!--
                <div class="drop-2 elem">
                    MOUVEMENTS Sortie
                    <ul class="drop-items-2">
                        <li class="elem" id="activate-form-entry-vide"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 0, 'weight' => 6]) }}">6 KG
                                (sortie)</a>
                        </li>
                        <li class="elem" id="activate-form-entry-gpl"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 0, 'weight' => 12.5]) }}">12.5
                                KG
                                (sortie)</a></li>
                        <li class="elem" id="activate-form-entry-accessory"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 0, 'weight' => 50]) }}">50 KG
                                (sortie)</a></li>
                        <li class="elem" id="activate-form-entry-vide"><a
                                href="{{ route('moveEntryCom', ['state' => 1, 'type' => 0, 'weight' => 0]) }}">ACCESSOIRES
                                (sortie)</a></li>

                    </ul>
                </div> -->
                <!--
                <div class="drop-2 elem">
                    MOUVEMENTS Global
                    <ul class="drop-items-2">
                        <li class="elem"><a
                                href="{{ route('moveGlobalCom', ['type' => 'bouteille-gaz', 'weight' => 6]) }}">6 KG
                                (global)</a></li>
                        <li class="elem"><a
                                href="{{ route('moveGlobalCom', ['type' => 'bouteille-gaz', 'weight' => 12.5]) }}">12.5
                                KG
                                (global)</a></li>
                        <li class="elem"><a
                                href="{{ route('moveGlobalCom', ['type' => 'bouteille-gaz', 'weight' => 50]) }}">50 KG
                                (global)</a></li>
                        <li class="elem"><a
                                href="{{ route('moveGlobalCom', ['type' => 'accessoire', 'weight' => 0]) }}">ACCESSOIRES
                                (global)</a></li>

                    </ul>
                </div> -->
                <div class="drop-2 elem">
                    <a href="{{ route('showVentes', ['type' => 'vente']) }}"> VENTES</a>
                </div>
                <div class="drop-2 elem">
                    <a href="{{ route('showVentes', ['type' => 'consigne']) }}"> CONSIGNES</a>
                </div>
                <div class="drop-2 elem">
                    <a href="{{ route('showVentes', ['type' => 'versements']) }}"> VERSEMENTS</a>
                </div>
            </div>
        </div>
        <div class="font-bold cursor-pointer dropdown relative">GENERER UN DOCUMENT<i
                class="fa-solid fa-angle-down"></i>
            <ul class="drop-items">

                <!-- <li class="elem" id="activate-pdf-form">Etats des mouvements</li> -->
                <li class="elem" id="activate-sales-state-pdf-form">Etats des Ventes</li>
                <li class="elem text-red-600" id="activate-new-sales-state-pdf-form">Etats des vente nouveau</li>
                <li class="elem" id="activate-versement-pdf-form">Historique des Versements</li>
            </ul>
        </div>
    </nav>

    <!--FORMULAIRE GENERATION ETAT DES VENTES NOUVEAU-->

    <div id="new-sales-pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF historique des ventes/consignes <span class="text-red-500"> Nouveau</span></h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('new-sales-pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart">
                        @if ($errors->has('depart'))
                            <b class="text-red-500">{{ $errors->first('depart') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin">
                        @if ($errors->has('fin'))
                            <b class="text-red-500">{{ $errors->first('fin') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Client :</label><br>

                        <select name="client" id="">

                            <option value="all">Tous</option>
                            @foreach ($clientsList as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('state'))
                        <b class="text-red-500">{{ $errors->first('state') }}</b>
                    @endif
                    <div class="modal-champs">
                        <label for="">Type de Action</label>
                        <select name="sale" id="">

                            <option value="vente">vente</option>
                            <option value="consigne">consigne</option>

                        </select>
                        @if ($errors->has('move'))
                            <b class="text-red-500">{{ $errors->first('move') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Article:</label>
                        <select name="article" id="">
                            @foreach ($articlesList as $article)
                                <option value="{{ $article->id }}">
                                    {{ $article->type == 'accessoire' ? $article->title : $article->weight . ' kg' }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('move'))
                            <b class="text-red-500">{{ $errors->first('move') }}</b>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <!--FORMULAIRE GENERATION ETAT DES VERSEMENTS-->

    <div id="versement-pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF historique des versements</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('versementPdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart">
                        @if ($errors->has('depart'))
                            <b class="text-red-500">{{ $errors->first('depart') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin">
                        @if ($errors->has('fin'))
                            <b class="text-red-500">{{ $errors->first('fin') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">BANQUE :</label><br>

                        <select name="bank" id="">
                            <option value="AFB">AFB</option>
                            <option value="CCA">CCA</option>
                            <option value="CAISSE">CAISSE</option>
                            <option value="all">Tous</option>
                        </select>
                    </div>
                    @if ($errors->has('bank'))
                        <b class="text-red-500">{{ $errors->first('bank') }}</b>
                    @endif
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <!--FORMULAIRE GENERATION ETAT DES VENTES NOUVEAU-->

    <div id="sales-state-pdf-form" class="modals">

        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF etats des ventes/consignes</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('sale_state_pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart">
                        @if ($errors->has('depart'))
                            <b class="text-red-500">{{ $errors->first('depart') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin">
                        @if ($errors->has('fin'))
                            <b class="text-red-500">{{ $errors->first('fin') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Client :</label><br>

                        <input type="text" name="name">
                    </div>
                    @if ($errors->has('state'))
                        <b class="text-red-500">{{ $errors->first('state') }}</b>
                    @endif
                    <div class="modal-champs">
                        <label for="">Type de Action</label>
                        <select name="sale" id="">

                            <option value="vente">vente</option>
                            <option value="consigne">consigne</option>
                            <option value="accessoire">accessoire</option>

                        </select>
                        @if ($errors->has('move'))
                            <b class="text-red-500">{{ $errors->first('move') }}</b>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>

    <!--FORMULAIRE GENERATION ETAT DES VENTES-->

    <div id="sales-state-pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF etats des ventes/consignes</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('sale_state_pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart">
                        @if ($errors->has('depart'))
                            <b class="text-red-500">{{ $errors->first('depart') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin">
                        @if ($errors->has('fin'))
                            <b class="text-red-500">{{ $errors->first('fin') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Client :</label><br>

                        <input type="text" name="name">
                    </div>
                    @if ($errors->has('state'))
                        <b class="text-red-500">{{ $errors->first('state') }}</b>
                    @endif
                    <div class="modal-champs">
                        <label for="">Type de Action</label>
                        <select name="sale" id="">

                            <option value="vente">vente</option>
                            <option value="consigne">consigne</option>
                            <option value="accessoire">accessoire</option>

                        </select>
                        @if ($errors->has('move'))
                            <b class="text-red-500">{{ $errors->first('move') }}</b>
                        @endif
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <!--FORMULAIRE DE VERSEMENTS-->
    <div id="versement" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Faire un Versement</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form id="versement-form" method="POST" action="{{ route('makeVersement') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Montant GPL:</label>
                        <input type="number" name="montant_gpl" required>
                        @if ($errors->has('montant_gpl'))
                            <b class="text-red-500">{{ $errors->first('montant_gpl') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Montant Consigne:</label>
                        <input type="number" name="montant_consigne" required>
                        @if ($errors->has('montant_consigne'))
                            <b class="text-red-500">{{ $errors->first('montant_consigne') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Banque:</label>
                        <select name="bank" id="">
                            <option value="{{ env('COMPANIE_BANK_1') }}">{{ env('COMPANIE_BANK_1') }}</option>
                            <option value="{{ env('COMPANIE_BANK_2') }}">{{ env('COMPANIE_BANK_2') }}</option>
                            <option value="CAISSE">CAISSE</option>
                        </select>
                        @if ($errors->has('bank'))
                            <b class="text-red-500">{{ $errors->first('bank') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero de Bordereau:</label>
                        <input type="text" name="bordereau" required>
                    </div>
                    <div class="modal-champs">
                        <label for="">Commentaire:</label>
                        <input type="text" name="commentaire">
                        @if ($errors->has('commentaire'))
                            <b class="text-red-500">{{ $errors->first('commentaire') }}</b>
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
    <div id="pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Du:</label>
                        <input type="date" name="depart">
                        @if ($errors->has('depart'))
                            <b class="text-red-500">{{ $errors->first('depart') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Au:</label>
                        <input type="date" name="fin">
                        @if ($errors->has('fin'))
                            <b class="text-red-500">{{ $errors->first('fin') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">etat :</label><br>

                        <input type="radio" value="1" name="state"> pleine
                        <input type="radio" value="0" name="state">vide
                        <input type="radio" value="777" name="state">accessoire
                    </div>
                    @if ($errors->has('state'))
                        <b class="text-red-500">{{ $errors->first('state') }}</b>
                    @endif
                    <div class="modal-champs">
                        <label for="">Type de Movement</label>
                        <select name="move" id="">

                            <option value="1">entree</option>
                            <option value="0">sortie</option>
                            <option value="777">Global</option>

                        </select>
                        @if ($errors->has('move'))
                            <b class="text-red-500">{{ $errors->first('move') }}</b>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Service</label>
                        <select name="service" id="">

                            <option value="{{ Auth::user()->role }}">{{ Auth::user()->role }}</option>

                        </select>
                        @if ($errors->has('service'))
                            <b class="text-red-500">{{ $errors->first('service') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Region</label>
                        <select name="region" id="">

                            <option value="{{ Auth::user()->region }}">{{ Auth::user()->region }}</option>


                        </select>
                        @if ($errors->has('region'))
                            <b class="text-red-500">{{ $errors->first('region') }}</b>
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
                            <b class="text-red-500">{{ $errors->first('type') }}</b>
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
    <!-- ventes FORMULAIRES -->
    <div id="sale-gpl" class="modals">
        <center>

            <div class="modal-active w-full md-6/12">
                <div class="modal-head">
                    <h1>Vente GPL</h1>
                    <b class="close-modal">X</b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form action="{{ route('makeSales', ['type' => 'vente']) }}" method="POST">
                    @csrf

                    <div class="w-full text-center">
                        <label for="">Type de bouteilles</label>
                        <div class="w-full flex gap-1 sub-form">
                            <div class=" ">
                                6kg
                                <div class="flex gap-2">
                                    <input type="number" name="prix_6" placeholder="prix U" required>
                                    <input type="number" name="qty_6" placeholder="qte" id="" required>
                                </div>
                            </div>
                            <div class=" ">
                                12.5kg

                                <div class="flex  gap-2 ">
                                    <input type="number" name="prix_12" placeholder="prix U" required>
                                    <input type="number" name="qty_12" placeholder="qte" id="" required>
                                </div>
                            </div>
                            <div class=" ">
                                50 kg

                                <div class="flex  gap-2 ">
                                    <input type="number" name="prix_50" placeholder="prix U" required>
                                    <input type="number" name="qty_50" placeholder="qte" id="" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-champs">
                        <label for="">Nom Client</label>
                        <input type="text" name="costumer" required>
                        @if ($errors->has('costumer'))
                            <b class="text-red-500">{{ $errors->first('costumer') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero Client</label>
                        <input type="number" name="numero" required>
                        @if ($errors->has('numero'))
                            <b class="text-red-500">{{ $errors->first('numero') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Adresse du client :</label>
                        <input type="text" name="address" id="unit_price" required>
                        @if ($errors->has('text'))
                            <b class="text-red-500">{{ $errors->first('text') }}</b>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Type de Paiement</label>
                        <select name="currency">
                            <option value="cash">Cash</option>
                            <option value="virement">Virement</option>
                        </select>
                        @if ($errors->has('currency'))
                            <b class="text-red-500">{{ $errors->first('currency') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <h2>Montant : <b></b></h2>
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <!-- ventes ACCESSOIRES FORMULAIRES -->
    <div id="acSales-form" class="modals">
        <center>

            <div class="modal-active w-full md-6/12">
                <div class="modal-head">
                    <h1>Vente Accesoires</h1>
                    <b class="close-modal">X</b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form id="sale-gpl-for" action="{{ route('makeAcSales', ['type' => 'accessoire']) }}"
                    method="POST">
                    @csrf

                    <div class="w-full text-center">
                        <div class="modal-champs">
                            <label for="">Accessoire</label>
                            <select name="accessoire" id="">
                                @foreach ($accessories as $accessory)
                                    <option value="{{ $accessory->title }}">{{ $accessory->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-champs">
                        <label for="">Qte</label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <b class="text-red-500">{{ $errors->first('qty') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Prix U.</label>
                        <input type="number" name="prix" required>
                        @if ($errors->has('prix'))
                            <b class="text-red-500">{{ $errors->first('prix') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Nom Client</label>
                        <input type="text" name="costumer" required>
                        @if ($errors->has('customer'))
                            <b class="text-red-500">{{ $errors->first('customer') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero de telephone Client</label>
                        <input type="number" name="numero" required>
                        @if ($errors->has('numero'))
                            <b class="text-red-500">{{ $errors->first('numero') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Adresse du client :</label>
                        <input type="text" name="address" id="unit_price" required>
                        @if ($errors->has('text'))
                            <b class="text-red-500">{{ $errors->first('text') }}</b>
                        @endif
                    </div>

                    <div class="modal-champs">
                        <label for="">Type de Paiement</label>
                        <select name="currency">
                            <option value="cash">Cash</option>
                            <option value="virement">Virement</option>
                        </select>
                        @if ($errors->has('currency'))
                            <b class="text-red-500">{{ $errors->first('currency') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <h2>Montant : <b></b></h2>
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <!-- CONSIGNES FORMULAIRES -->
    <div id="consigne" class="modals">
        <center>

            <div class="modal-active w-full md-6/12">
                <div class="modal-head">
                    <h1>Consignes</h1>
                    <b class="close-modal">X</b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form id="consigne-for" action="{{ route('makeSales', ['type' => 'consigne']) }}" method="POST">
                    @csrf

                    <div class="w-full text-center">
                        <label for="">Type de bouteilles:</label>
                        <div class="w-full flex gap-1 sub-form">
                            <div class=" ">
                                6kg
                                <div class="flex gap-2">
                                    <input type="number" name="prix_6" placeholder="prix U" required>
                                    <input type="number" name="qty_6" placeholder="qte" id="" required>
                                </div>
                            </div>
                            <div class=" ">
                                12.5kg

                                <div class="flex  gap-2 ">
                                    <input type="number" name="prix_12" placeholder="prix U" required>
                                    <input type="number" name="qty_12" placeholder="qte" id="" required>
                                </div>
                            </div>
                            <div class=" ">
                                50 kg

                                <div class="flex  gap-2 ">
                                    <input type="number" name="prix_50" placeholder="prix U" required>
                                    <input type="number" name="qty_50" placeholder="qte" id="" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-champs">
                        <label for="">Nom Client</label>
                        <input type="text" name="costumer" required>
                        @if ($errors->has('costumer'))
                            <b class="text-red-500">{{ $errors->first('costumer') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Adresse du client :</label>
                        <input type="text" name="address" id="unit_price" required>
                        @if ($errors->has('text'))
                            <b class="text-red-500">{{ $errors->first('text') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Numero de telephone Client</label>
                        <input type="number" name="numero" required>
                        @if ($errors->has('numero'))
                            <b class="text-red-500">{{ $errors->first('numero') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type de Paiement</label>
                        <select name="currency">
                            <option value="cash">Cash</option>
                            <option value="virement">Virement</option>
                        </select>
                        @if ($errors->has('currency'))
                            <b class="text-red-500">{{ $errors->first('currency') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <h2>Montant : <b></b></h2>
                    </div>
                    <div class="modal-validation">
                        <button type="reset">annuler</button>
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>


    <!--ENTREE FORMULAIRES-->

    <div id="entry-pleine" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de Bouteilles Pleines</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500 "></b>
                <b class="errors text-red-500 "></b>
                <form id="entry-pleine-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            <option value="magasin central">MAGASIN CENTRAL</option>
                            <option value="Retour sur Vente">Retour sur Vente</option>
                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('origin'))
                            <b class="text-red-500">{{ $errors->first('origin') }}</b>
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
                            <b class="text-red-500">{{ $errors->first('qty') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle</label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <b class="text-red-500">{{ $errors->first('label') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <b class="text-red-500">{{ $errors->first('bord') }}</b>
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


    <div id="entry-vides" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de Bouteilles Vides</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form id="entry-vides-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            <option value="client">client</option>
                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('origin'))
                            <b class="text-red-500">{{ $errors->first('origin') }}</b>
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
                            <b class="text-red-500">{{ $errors->first('qty') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle</label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <b class="text-red-500">{{ $errors->first('label') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <b class="text-red-500">{{ $errors->first('bord') }}</b>
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


    <div id="entry-accessory" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entree de Accessoire</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
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
                            <b class="text-red-500">{{ $errors->first('title') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="operation" id="">

                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('operation'))
                            <b class="text-red-500">{{ $errors->first('operation') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite :</label>
                        <input type="number" name="qty" required>
                    </div>
                    @if ($errors->has('qty'))
                        <b class="text-red-500">{{ $errors->first('qty') }}</b>
                    @endif
                    <div class="modal-champs">
                        <label for="">Libelle</label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <b class="text-red-500">{{ $errors->first('label') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <b class="text-red-500">{{ $errors->first('bord') }}</b>
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

    <!--SORTIES FORMULAIRES-->

    <div id="outcome-pleine" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Bouteilles Pleines</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form id="outcome-pleine-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            <option value="client">client</option>
                            <option value="region">region</option>
                        </select>
                        @if ($errors->has('origin'))
                            <b class="text-red-500">{{ $errors->first('origin') }}</b>
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
                            <b class="text-red-500">{{ $errors->first('qty') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle </label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <b class="text-red-500">{{ $errors->first('label') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <b class="text-red-500">{{ $errors->first('bord') }}</b>
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



    <div id="outcome-vides" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Bouteilles Vides</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form id="outcome-vides-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="origin" id="">
                            <option value="client">client</option>
                            <option value="region">region</option>
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
                </form>
            </div>
        </center>
    </div>



    <div id="outcome-accessory" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Accessoire</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form id="outcome-accessory-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="">Type d'accessiore:</label>
                        <select name="title" id="">
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->title }}">{{ $accessory->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('title'))
                            <b class="text-red-500">{{ $errors->first('title') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Type d'operation:</label>
                        <select name="operation" id="">

                            <option value="stock_initial">stock initial</option>
                        </select>
                        @if ($errors->has('operation'))
                            <b class="text-red-500">{{ $errors->first('operation') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Quantite :</label>
                        <input type="number" name="qty" required>
                        @if ($errors->has('qty'))
                            <b class="text-red-500">{{ $errors->first('qty') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Libelle:</label>
                        <input type="text" name="label" required>
                        @if ($errors->has('label'))
                            <b class="text-red-500">{{ $errors->first('label') }}</b>
                        @endif
                    </div>
                    <div class="modal-champs">
                        <label for="">Bordereau :</label>
                        <input type="text" name="bord" required>
                        @if ($errors->has('bord'))
                            <b class="text-red-500">{{ $errors->first('bord') }}</b>
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



    <div class="w-full overflow-x-scroll  ">
        @yield('content')
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
        //ACTION ENTRY ON MODAL GPL
        $(function() {
            //ACTION versement historique
            $("#activate-versement-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#versement-pdf-form").hasClass("modals")) {
                    $("#versement-pdf-form").addClass("modals-active");
                    $("#versement-pdf-form").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#versement-pdf-form").hasClass("modals-active")) {
                        $("#versement-pdf-form").addClass("modals");
                        $("#versement-pdf-form").removeClass("modals-active");
                    }
                })
            })

            //ACTION ACCESSORY SALES
            $("#activate-acSales-form").on("click", function(e) {
                e.preventDefault()
                if ($("#acSales-form").hasClass("modals")) {
                    $("#acSales-form").addClass("modals-active");
                    $("#acSales-form").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#acSales-form").hasClass("modals-active")) {
                        $("#acSales-form").addClass("modals");
                        $("#acSales-form").removeClass("modals-active");
                    }
                })
            })
            //ACTIon faire versement 
            $("#activate-versement-form").on("click", function(e) {
                e.preventDefault()
                if ($("#versement").hasClass("modals")) {
                    $("#versement").addClass("modals-active");
                    $("#versement").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#versement").hasClass("modals-active")) {
                        $("#versement").addClass("modals");
                        $("#versement").removeClass("modals-active");
                    }
                })
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
            //calcul prix total
            $("#unit_price").change(function() {
                var unit_val = $(this).val()
                alert(val)
            })
            $("#qty_gpl").change(function() {
                var qty_gpl = $(this).val()
                alert(val)
            })

            //ACTION VENTE GPL
            $("#activate-form-sale-gpl").on("click", function(e) {
                e.preventDefault()
                if ($("#sale-gpl").hasClass("modals")) {
                    $("#sale-gpl").addClass("modals-active")

                    $("#sale-gpl").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#sale-gpl").hasClass("modals-active")) {
                    $("#sale-gpl").addClass("modals")
                    $("#sale-gpl").removeClass("modals-active")
                }
            })

            //ACTION VENTE GPL
            $("#activate-form-consigne").on("click", function(e) {
                e.preventDefault()
                if ($("#consigne").hasClass("modals")) {
                    $("#consigne").addClass("modals-active")

                    $("#consigne").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#consigne").hasClass("modals-active")) {
                    $("#consigne").addClass("modals")
                    $("#consigne").removeClass("modals-active")
                }
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
            //ACTION SALES STATE PDF FORM
            $("#activate-sales-state-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#sales-state-pdf-form").hasClass("modals")) {
                    $("#sales-state-pdf-form").addClass("modals-active")

                    $("#sales-state-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#sales-state-pdf-form").hasClass("modals-active")) {
                    $("#sales-state-pdf-form").addClass("modals")
                    $("#sales-state-pdf-form").removeClass("modals-active")
                }
            })

            //ACTION NEW SALES STATE PDF FORM
            $("#activate-new-sales-state-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#new-sales-pdf-form").hasClass("modals")) {
                    $("#new-sales-pdf-form").addClass("modals-active")

                    $("#new-sales-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#new-sales-pdf-form").hasClass("modals-active")) {
                    $("#new-sales-pdf-form").addClass("modals")
                    $("#new-sales-pdf-form").removeClass("modals-active")
                }
            })
            //ACTION OUTCOME ON MODAL BOUTEILLES-VIDES


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

            //FORMULAIRE ENTREES BOUTIELLES PLEINES
            $("#entry-pleine-form").submit(function(e) {
                e.preventDefault()

                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $.ajax({
                    url: "{{ route('saveBottleMoveCom', ['action' => 'entry', 'state' => 1]) }}",
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
                            $("#submitForm").prop("disabled", false);
                            $("#entry-pleine-form")[0].reset();
                        } else {
                            $(".errors").text("");
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#submitForm").prop("disabled", false);
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
                $.ajax({
                    url: "{{ route('saveBottleMoveCom', ['action' => 'entry', 'state' => 0]) }}",
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
                            $("#entry-vides-form")[0].reset();
                        } else {
                            $(".success").text(response.success);
                            $("#submitForm").prop("disabled", false);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $("#entry-vides-form")[0].reset();
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
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
                $.ajax({
                    url: "{{ route('saveAccessoryMoveCom', ['action' => 'entry']) }}",
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
                            $("#entry-accessory-form")[0].reset()
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#submitForm").prop("disabled", false);
                            $("#entry-accessory-form")[0].reset()
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
                $.ajax({
                    url: "{{ route('saveBottleMoveCom', ['action' => 'outcome', 'state' => 1]) }}",
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
                            $("#outcome-pleine-form")[0].reset()
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $(".success").text(response.success)
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#submitForm").prop("disabled", false);
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
                $.ajax({
                    url: "{{ route('saveBottleMoveCom', ['action' => 'outcome', 'state' => 0]) }}",
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
                            $("#outcome-vides-form")[0].reset()
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $(".success").text(response.success)
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#submitForm").prop("disabled", false);
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
                $.ajax({
                    url: "{{ route('saveAccessoryMoveCom', ['action' => 'outcome']) }}",
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
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#submitForm").prop("disabled", false);
                            $("#outcome-accessory-form")[0].reset();
                            $("table").load(location.href + " table")
                            $(".info").load(location.href + " .info")
                        }
                    }
                })
            })
            //VALIDATION FORMULAIRE DE VERSEMENT
            $("#versement-form").submit(function(e) {
                e.preventDefault()
                if ($("#submitForm").prop("disabled")) {
                    return;
                }
                $("#submitForm").prop("disabled", true);
                $('#loading').show();
                $.ajax({
                    url: "{{ route('makeVersement') }}",
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
                            $("#versement-form")[0].reset();
                        } else {
                            $(".errors").text("");
                            $("#submitForm").prop("disabled", false);
                            $('#loading').hide();
                            $(".success").text(response.success);
                            setTimeout(() => {
                                $(".success").text("");

                            }, 1500);
                            $("#submitForm").prop("disabled", false);
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
