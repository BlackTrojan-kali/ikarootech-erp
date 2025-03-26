<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('COMPANIE_NAME') }} SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>

<body class="mx-20">

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
    <header class="p-4">
        <div class="w-full flex justify-between">
            <img src="/images/logo.png" class="w-32 h-auto" alt="">
            <div class="text-center mt-2">
                <p>
                    <i class="fa-solid fa-user"></i>
                    {{ Auth::user()->email }}
                </p>
                <h2 class="text-large">Stargas Supply Chain Management System</h2>
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
        <nav class="mt-2 p-2 first-letter: w-full flex  gap-5 text-white primary rounded-md">
            <div> <a href="{{ route('bossDashboard') }}"><i class="fa-solid fa-home"></i> ACCUEIL</a></div>

            <div><a href="{{ route('showCiterneCon') }}">CITERNES</a></div>
            <div> <a href="{{ route('showReleveCon') }}">RECEPTION</a></div>
            <div class="dropdown cursor-pointer font-bold relative"> ETATS <i class="fa-solid fa-angle-down"></i>
                <div class="drop-items">


                    <div class="text-center elem"><a href="{{ route('historique-rel-con') }}">ETAT DES RELEVES</a>
                    </div>
                    <div class="drop-2 elem"><a href="{{ route('showConHist') }}">ETAT DES PRODUCTION</a></div>
                    <div class="drop-2 elem">
                        <a href="{{ route('showVentesCon', ['type' => 'vente']) }}"> VENTES</a>
                    </div>
                    <div class="drop-2 elem">
                        <a href="{{ route('showVentesCon', ['type' => 'consigne']) }}"> CONSIGNES</a>
                    </div>

                    <div class="drop-2 elem"><a href="{{ route('broutes-list-con') }}">Bordereaux de Route</a>
                    </div>
                    <div class="drop-2 elem">
                        <a href="{{ route('showVentesCon', ['type' => 'versements']) }}"> VERSEMENTS</a>
                    </div>

                </div>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">GENERER UN DOCUMENT PDF<i
                    class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem" id="activate-pdf-form">Etats des mouvements</li>
                    <li class="elem" id="activate-receives-pdf-form">Historique des receptions</li>
                    <li class="elem" id="activate-sales-state-pdf-form">Etats des Ventes</li>
                    <li class="elem" id="activate-versement-pdf-form">Historique des Versements</li>
                    <li class="elem" id="activate-releves-pdf-form">Historique des releves</li>
                    <li class="elem" id="activate-produce-pdf-form">Etats des ProductionS</li>

                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">GENERER UN DOCUMENT EXCEL<i
                    class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem" id="activate-move-excels-form">Etats des
                        mouvements
                    </li>
                    <li class="elem" id="activate-receives-excel-form">Historique des receptions</li>
                    <li class="elem" id="activate-sales-state-excel-form">Etats des Ventes</li>
                    <li class="elem" id="activate-versement-excel-form">Historique des Versements</li>
                    <li class="elem" id="activate-releves-excel-form">Historique des releves</li>
                    <li class="elem" id="activate-produce-excel-form">Etats des ProductionS</li>

                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">GERER CLIENTS<i class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <!-- <li class="elem" id="activate-pdf-form">Etats des mouvements</li> -->
                    <li class="elem"><a href="{{ route('client-cats') }}">CATEGORIES CLIENTS</a></li>
                    <li class="elem"><a href="{{ route('list-clients') }}">CLIENTS</a></li>
                    <li class="elem"><a href="{{ route('client-price') }}">PRIX CLIENTS</a></li>
                </ul>
            </div>
        </nav>
    </header>


    <!--FORMULAIRE DE GENERATION DE EXCEL-->
    <div id="move-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un Fichier Excel</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('export-excelts') }}">
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

                        <input type="radio" value="1" name="state"> GLOBAL
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

                            <option value="production">production</option>
                            <option value="magasin">magasin</option>
                            <option value="commercial">commmercial</option>

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
    <!--FORMULAIRE DE GENERATION DE EXCEL RECEPTIONS-->
    <div id="recieves-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF RECEPTIONS</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('receives_boss_excel') }}">
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
                        <label for="">Service:</label>
                        <select name="service" required>
                            <option value="magasin">Magasin</option>
                            <option value="production">Production</option>
                        </select>
                        @if ($errors->has('service'))
                            <span class="text-red-500">{{ $errors->first('service') }}</span>
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
    <!--FORMULAIRE GENERATION ETAT DES VENTES EN EXCEL-->

    <div id="sales-state-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un EXCEL etats des ventes/consignes</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('boss_sale_state_excel') }}">
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
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <!--FORMULAIRE DE GENERATION PDF-->
    <div id="recieves-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF RECEPTIONS</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('receives_boss_pdf') }}">
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
                        <label for="">Service:</label>
                        <select name="service" required>
                            <option value="magasin">Magasin</option>
                            <option value="production">Production</option>
                        </select>
                        @if ($errors->has('service'))
                            <span class="text-red-500">{{ $errors->first('service') }}</span>
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
    <!--FORMULAIRE GENERATION ETAT DES VERSEMENTS-->

    <div id="versement-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un EXCEL historique des versements</h1>
                    <b class="close-modal">X </b>
                </div>
                <b class="success text-green-500"></b>
                <b class="errors text-red-500"></b>
                <form method="POST" action="{{ route('boss_versementexcel') }}">
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
                    <div class="modal-champs">
                        <label for="">service</label>
                        <select name="service" id="">
                            <option value="commercial">Commercial</option>

                        </select>
                        @if ($errors->has('region'))
                            <span class="text-red-500">{{ $errors->first('region') }}</span>
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
    <!--FORMULAIRE DE GENERATION DE PDF RElEVEES-->
    <div id="releves-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un Excel RELEVES</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('releves_excel') }}">
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

    <!--FORMULAIRE DE GENERATION DE EXCEL PRODUCTION-->
    <div id="produce-excel-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un Excel Production</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('genProdHistConExcel') }}">
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

    <!--FORMULAIRE DE GENERATION DE PDF PRODUCTION-->
    <div id="produce-pdf-form" class="modals">
        <center>

            <div class="modal-active">
                <div class="modal-head">
                    <h1>Generer un PDF Production</h1>
                    <span class="close-modal">X </span>
                </div>
                <span class="success text-green-500"></span>
                <span class="errors text-red-500"></span>
                <form method="POST" action="{{ route('genProdHistCon') }}">
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
                <form method="POST" action="{{ route('receives_boss_pdf') }}">
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
                        <label for="">Service:</label>
                        <select name="service" required>
                            <option value="magasin">Magasin</option>
                            <option value="production">Production</option>
                        </select>
                        @if ($errors->has('service'))
                            <span class="text-red-500">{{ $errors->first('service') }}</span>
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
                <form method="POST" action="{{ route('pdfController') }}">
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

                            <option value="production">production</option>
                            <option value="magasin">magasin</option>
                            <option value="commercial">commmercial</option>

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
                <form method="POST" action="{{ route('boss_versementPdf') }}">
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
                    <div class="modal-champs">
                        <label for="">service</label>
                        <select name="service" id="">
                            <option value="commercial">Commercial</option>

                        </select>
                        @if ($errors->has('region'))
                            <span class="text-red-500">{{ $errors->first('region') }}</span>
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
                <form method="POST" action="{{ route('boss_sale_state_pdf') }}">
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
                        <button type="submit" id="submitForm">creer</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
    <div class=" overflow-x-scroll">
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
        $(function() {
            $('table').DataTable();
            //ACTION generate excel movements
            $("#activate-move-excels-form").on("click", function(e) {
                e.preventDefault()
                if ($("#move-excel-form").hasClass("modals")) {
                    $("#move-excel-form").addClass("modals-active")

                    $("#move-excel-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#move-excel-form").hasClass("modals-active")) {
                    $("#move-excel-form").addClass("modals")
                    $("#move-excel-form").removeClass("modals-active")
                }
            })
            //ACTION generate excel receives 
            $("#activate-receives-excel-form").on("click", function(e) {
                e.preventDefault()
                if ($("#recieves-excel-form").hasClass("modals")) {
                    $("#recieves-excel-form").addClass("modals-active")

                    $("#recieves-excel-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#recieves-excel-form").hasClass("modals-active")) {
                    $("#recieves-excel-form").addClass("modals")
                    $("#recieves-excel-form").removeClass("modals-active")
                }
            })
            //ACTION GENERER EXCEL VENTES

            $("#activate-sales-state-excel-form").on("click", function(e) {
                e.preventDefault()
                if ($("#sales-state-excel-form").hasClass("modals")) {
                    $("#sales-state-excel-form").addClass("modals-active")

                    $("#sales-state-excel-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#sales-state-excel-form").hasClass("modals-active")) {
                    $("#sales-state-excel-form").addClass("modals")
                    $("#sales-state-excel-form").removeClass("modals-active")
                }
            })
            //ACTION versement historique Excel
            $("#activate-versement-excel-form").on("click", function(e) {
                e.preventDefault()
                if ($("#versement-excel-form").hasClass("modals")) {
                    $("#versement-excel-form").addClass("modals-active");
                    $("#versement-excel-form").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#versement-excel-form").hasClass("modals-active")) {
                        $("#versement-excel-form").addClass("modals");
                        $("#versement-excel-form").removeClass("modals-active");
                    }
                })
            })
            //ACTION generate excel releves 
            $("#activate-releves-excel-form").on("click", function(e) {
                e.preventDefault()
                if ($("#releves-excel-form").hasClass("modals")) {
                    $("#releves-excel-form").addClass("modals-active")

                    $("#releves-excel-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#releves-excel-form").hasClass("modals-active")) {
                    $("#releves-excel-form").addClass("modals")
                    $("#releves-excel-form").removeClass("modals-active")
                }
            })
            //ACTION generate pdf produce
            $("#activate-produce-excel-form").on("click", function(e) {
                e.preventDefault()
                if ($("#produce-excel-form").hasClass("modals")) {
                    $("#produce-excel-form").addClass("modals-active")

                    $("#produce-excel-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#produce-excel-form").hasClass("modals-active")) {
                    $("#produce-excel-form").addClass("modals")
                    $("#produce-excel-form").removeClass("modals-active")
                }
            })
            //ACTION generate pdf produce
            $("#activate-produce-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#produce-pdf-form").hasClass("modals")) {
                    $("#produce-pdf-form").addClass("modals-active")

                    $("#produce-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#produce-pdf-form").hasClass("modals-active")) {
                    $("#produce-pdf-form").addClass("modals")
                    $("#produce-pdf-form").removeClass("modals-active")
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
            //ACTIon GENERATE PDF
            $("#activate-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#pdf-form").hasClass("modals")) {
                    $("#pdf-form").addClass("modals-active");
                    $("#pdf-form").removeClass("modals");
                }
            })
            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#pdf-form").hasClass("modals-active")) {
                    $("#pdf-form").addClass("modals");
                    $("#pdf-form").removeClass("modals-active");
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
            }) //ACTION versement historique
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



        })
    </script>
</body>

</html>
