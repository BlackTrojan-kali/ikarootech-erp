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

    {{-- Toastr notifications --}}
    @if (session('success'))
        <script type="module">
            $(document).ready(function() {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @elseif ($errors->has('message'))
        <script type="module">
            $(document).ready(function() {
                toastr.error("{{ $errors->first('message') }}");
            });
        </script>
    @endif

    <header class="p-4 text-sm md:text-base">
        <div class="w-full flex justify-between items-center"> {{-- Added items-center for vertical alignment --}}
            <img src="/images/logo.png" class="w-28 md:w-32 h-auto" alt="Company Logo"> {{-- Added alt attribute --}}
            <div class="text-center mt-2">
                <p>
                    <i class="fa-solid fa-user" aria-hidden="true"></i> {{-- Added aria-hidden for icons --}}
                    {{ Auth::user()->email }}
                </p>
                <h1 class="text-large">{{ env('COMPANIE_NAME') }} Supply Chain Management System</h1> {{-- Changed to h1 as it's the main title --}}
                <h2 class="text-large">
                    Region: {{ strtoupper(Auth::user()->region) }}
                </h2>
                <h2 class="text-large">
                    Service: {{ Auth::user()->role }}
                </h2>
            </div>
            <div class="mt-10 cursor-pointer text-center">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" aria-label="Déconnexion"> {{-- Added aria-label for accessibility --}}
                        <i class="fa-solid fa-right-from-bracket text-red-800 text-4xl" aria-hidden="true"></i>
                        <p>Déconnexion</p> {{-- Corrected spelling: deconnexion -> Déconnexion --}}
                    </button>
                </form>
            </div>
        </div>

        <nav class="mt-2 p-2 w-full text-white flex flex-col md:flex-row gap-4 primary rounded-md">
            <div><a href="{{ route('dashboard-manager') }}"><i class="fa-solid fa-home" aria-hidden="true"></i> ACCUEIL</a></div> {{-- Corrected spelling: ACCEUIL -> ACCUEIL --}}

            <div class="font-bold cursor-pointer dropdown relative">
                MOUVEMENTS <i class="fa-solid fa-angle-down" aria-hidden="true"></i>
                <div class="drop-items">
                    <div class="drop-2 elem">
                        Entrée {{-- Corrected spelling: Entree -> Entrée --}}
                        <ul class="drop-items-2">
                            <li class="elem" id="activate-form-entry-gpl"><a>GPL Vrac</a></li>
                            <li class="elem" id="activate-transmit-form"><a>Transfert Vrac</a></li> {{-- Corrected spelling: Tranfert -> Transfert --}}
                            <li class="elem" id="activate-form-entry-vide"><a>Bouteilles Vides</a></li>
                            <li class="elem" id="activate-form-entry-pleine"><a>Bouteilles Pleines</a></li>
                            <li class="elem" id="activate-form-entry-accessory"><a>Accessoires</a></li>
                        </ul>
                    </div>
                    <div class="drop-2 elem">
                        Sortie
                        <ul class="drop-items-2">
                            {{-- <li class="elem " id="activate-form-outcome-gpl"><a href="">GPL Vrac (sortie)</a></li> --}}
                            <li class="elem" id="activate-form-outcome-vide"><a>Bouteilles Vides (sortie)</a></li>
                            <li class="elem" id="activate-form-outcome-pleine"><a>Bouteilles Pleines (sortie)</a></li>
                            <li class="elem" id="activate-form-outcome-accessory"><a>Accessoires (sortie)</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div><a href="{{ route('showCiterneMan') }}">CITERNES</a></div>
            {{-- <div> <a href="{{ route('manager-histories') }}">HISTORIQUE</a></div> --}}
           {{-- <div> <a href="{{ route('showReleve') }}">RÉCEPTION</a></di Corrected spelling: RECEPTION -> RÉCEPTION --}}

            <div class="dropdown cursor-pointer font-bold relative">
                ÉTATS <i class="fa-solid fa-angle-down" aria-hidden="true"></i> {{-- Corrected spelling: ETATS -> ÉTATS --}}
                <div class="drop-items text-enter">
                      <li class="elem" > <a href="{{ route('showReleve') }}">ETAT RÉCEPTION GPL</a>
                   </li>
                        <div class="drop-2 elem">
                        MOUVEMENTS ENTRÉES {{-- Corrected spelling: ENTREES -> ENTRÉES --}}
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
                                    KG (sortie)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveEntryMan', ['state' => 1, 'type' => 0, 'weight' => 50]) }}">50
                                    KG (sortie)</a></li>
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
                                    KG (global)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'bouteille-gaz', 'weight' => 12.5]) }}">12.5
                                    KG (global)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'bouteille-gaz', 'weight' => 50]) }}">50
                                    KG (global)</a></li>
                            <li class="elem"><a
                                    href="{{ route('moveGlobalMan', ['type' => 'accessoire', 'weight' => 0]) }}">ACCESSOIRES
                                    (global)</a></li>
                        </ul>
                    </div>
                    <div class="text-center elem"><a href="{{ route('historique-rel') }}">États Relèves</a></div> {{-- Corrected spelling: Etats Releves -> États Relèves --}}
                    <div class="text-center elem"><a href="{{ route('broutes-list-man') }}">Bordereaux de Route</a></div>
                </div>
            </div>

            <div class="font-bold cursor-pointer dropdown relative">
                GÉNÉRER UN DOCUMENT <i class="fa-solid fa-angle-down" aria-hidden="true"></i> {{-- Corrected spelling: GENERER -> GÉNÉRER --}}
                <ul class="drop-items">
                    <li class="elem" id="activate-pdf-form">États des mouvements</li> {{-- Corrected spelling: Etats -> États --}}
                    <li class="elem" id="activate-receives-pdf-form">Historique des réceptions</li> {{-- Corrected spelling: historique des reception -> Historique des réceptions --}}
                    <li class="elem" id="activate-releves-pdf-form">Historique des relevés</li> {{-- Corrected spelling: historique des releves -> Historique des relevés --}}
                    <li class="elem" id="activate-broute-pdf-form">Bordereau de route</li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="w-full overflow-x-scroll md:overflow-x-hidden"> {{-- Changed div to main for semantic HTML --}}
        @yield('content')
    </main>
    <br><br><br><br><br><br><br><br>

    {{-- FORMULAIRE DE GÉNÉRATION DE PDF RELÈVES --}}
    <div id="releves-pdf-form" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Générer un PDF RELÈVES</h1> {{-- Corrected spelling: Generer -> Générer --}}
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span> {{-- Added role and aria-label --}}
                </div>
                <span class="success text-green-500" role="status"></span> {{-- Added role for accessibility --}}
                <span class="errors text-red-500" role="alert"></span> {{-- Added role for accessibility --}}
                <form method="POST" action="{{ route('releves_pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="releves_depart">Du:</label>
                        <input type="date" id="releves_depart" name="depart" required>
                        @error('depart')
                            <span class="text-red-500">{{ $message }}</span> {{-- Using @error directive for cleaner error display --}}
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="releves_fin">Au:</label>
                        <input type="date" id="releves_fin" name="fin" required>
                        @error('fin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="releves_citerne">Citerne:</label>
                        <select name="citerne" id="releves_citerne">
                            @foreach ($fixe as $fix)
                                <option value="{{ $fix->name }}">{{ $fix->name }}</option>
                            @endforeach
                            <option value="global">Global</option>
                        </select>
                        @error('citerne')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormRelevesPdf">Créer</button> {{-- Unique ID for submit button --}}
                    </div>
                </form>
            </div>
        </center>
    </div>

    {{-- FORMULAIRE DE GÉNÉRATION DE PDF RÉCEPTIONS --}}
    <div id="recieves-pdf-form" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Générer un PDF RÉCEPTIONS</h1> {{-- Corrected spelling --}}
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form method="POST" action="{{ route('receives_pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="receives_depart">Du:</label>
                        <input type="date" id="receives_depart" name="depart" required>
                        @error('depart')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="receives_fin">Au:</label>
                        <input type="date" id="receives_fin" name="fin" required>
                        @error('fin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="receives_citerne">Citerne:</label>
                        <select name="citerne" id="receives_citerne">
                            @foreach ($mobile as $fix)
                                <option value="{{ $fix->id }}">{{ $fix->name }}</option>
                            @endforeach
                            <option value="global">Global</option>
                        </select>
                        @error('citerne')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormReceivesPdf">Créer</button> {{-- Unique ID --}}
                    </div>
                </form>
            </div>
        </center>
    </div>

    {{-- FORMULAIRE DE GÉNÉRATION DE PDF --}}
    <div id="pdf-form" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Générer un PDF</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form method="POST" action="{{ route('pdf') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="pdf_depart">Du:</label>
                        <input type="date" id="pdf_depart" name="depart" required>
                        @error('depart')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="pdf_fin">Au:</label>
                        <input type="date" id="pdf_fin" name="fin" required>
                        @error('fin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label>État :</label><br> {{-- Corrected spelling --}}
                        <input type="radio" value="1" name="state" id="state_pleine"> <label for="state_pleine">Pleine</label>
                        <input type="radio" value="0" name="state" id="state_vide"> <label for="state_vide">Vide</label>
                        <input type="radio" value="777" name="state" id="state_accessoire"> <label for="state_accessoire">Accessoire</label>
                    </div>
                    @error('state')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <div class="modal-champs">
                        <label for="move_type">Type de Mouvement:</label> {{-- Corrected spelling --}}
                        <select name="move" id="move_type">
                            <option value="1">Entrée</option>
                            <option value="0">Sortie</option>
                            <option value="777">Global</option>
                        </select>
                        @error('move')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="service_type">Service:</label>
                        <select name="service" id="service_type">
                            <option value="{{ Auth::user()->role }}">{{ Auth::user()->role }}</option>
                        </select>
                        @error('service')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bottle_type">Type de bouteille:</label>
                        <select name="type" id="bottle_type">
                            <option value="50">50KG</option>
                            <option value="12.5">12.5KG</option>
                            <option value="6">6KG</option>
                            <option value="777">Accessoire</option>
                        </select>
                        @error('type')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormPdf">Créer</button> {{-- Unique ID --}}
                    </div>
                </form>
            </div>
        </center>
    </div>

    {{-- FORMULAIRE DE GÉNÉRATION DU BORDEREAU DE ROUTE --}}
    <div id="broute-form" class="modals">
        <center class="overflow-y-scroll">
            <div class="modal-active size-2">
                <div class="modal-head">
                    <h1>Générer un Bordereau de Route</h1> {{-- Corrected spelling --}}
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form method="POST" action="{{ route('gen-broute') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="matricule_vehicule">Immatriculation du véhicule:</label>
                        <input type="text" id="matricule_vehicule" required name="matricule">
                        @error('matricule')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="ville_depart">Ville de départ:</label>
                        <input type="text" id="ville_depart" required name="depart">
                        @error('depart')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="ville_arrivee">Ville d'arrivée:</label>
                        <input type="text" id="ville_arrivee" required name="arrivee">
                        @error('arrivee')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="date_depart">Date départ:</label>
                        <input type="date" id="date_depart" name="date_depart" required>
                        @error('date_depart')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="date_arrivee">Date Arrivée:</label>
                        <input type="date" id="date_arrivee" name="date_arrivee">
                        @error('date_arrivee')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="nom_chauffeur">Nom chauffeur :</label><br>
                        <input type="text" id="nom_chauffeur" name="nom_chauffeur" required>
                    </div>
                    @error('nom_chauffeur')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <div class="modal-champs">
                        <label for="permis_chauffeur">Permis:</label>
                        <input type="text" id="permis_chauffeur" name="permis" required />
                        @error('permis')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="aide_chauffeur">Aide Chauffeur:</label>
                        <input type="text" id="aide_chauffeur" name="aide_chauffeur">
                        @error('aide_chauffeur')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="contact_chauffeur">Contacts:</label>
                        <input type="text" id="contact_chauffeur" name="contact" required />
                        @error('contact')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="details_broute">Détails:</label> {{-- Corrected spelling --}}
                        <textarea name="details" id="details_broute" class="w-full border-2 border-gray-200" required></textarea>
                        @error('details')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormBroute">Créer</button> {{-- Unique ID --}}
                    </div>
                </form>
            </div>
        </center>
    </div>

    {{-- TRANSFERT GPL VRAC --}}
    <div id="transmit-form" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Dépôtage GPL Vrac</h1> {{-- Corrected spelling: Depotage -> Dépôt --}}
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="transmit-gpl-form" method="POST" action="{{ route('Depotage') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="mobile_citerne">Citerne Mobile:</label>
                        <select name="mobile" id="mobile_citerne">
                            @foreach ($vrac as $vra)
                                <option value="{{ $vra->id }}">{{ $vra->name }} - ({{ $vra->type }})</option>
                            @endforeach
                        </select>
                        @error('mobile')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="fixe_citerne">Citerne Fixe:</label>
                        <select name="fixe" id="fixe_citerne">
                            @foreach ($fixe as $fix)
                                <option value="{{ $fix->id }}">{{ $fix->name }} - ({{ $fix->type }})</option>
                            @endforeach
                        </select>
                        @error('fixe')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="qty_transfert">Quantité :</label>
                        <input type="number" id="qty_transfert" name="qty" required>
                    </div>
                    @error('qty')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <div class="modal-champs">
                        <label for="matricule_transfert">Matricule du Véhicule:</label>
                        <input type="text" id="matricule_transfert" name="matricule" required>
                        @error('matricule')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormTransmit">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingTransmit" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    {{-- ENTRÉE FORMULAIRES --}}
    <div id="entry-gpl" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entrée de GPL Vrac</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="entry-gpl-form" method="POST" action="{{ route('MoveGpl') }}">
                    @csrf
                    <div class="modal-champs">
                        <label for="citerne_entry_gpl">Type de citerne:</label>
                        <select name="citerne" id="citerne_entry_gpl">
                            @foreach ($vrac as $vra)
                                <option value="{{ $vra->name }}">{{ $vra->name }} - ({{ $vra->type }})</option>
                            @endforeach
                        </select>
                        @error('citerne')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="qty_entry_gpl">Quantité en KG:</label>
                        <input type="number" id="qty_entry_gpl" name="qty" required>
                        @error('qty')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="provenance_entry_gpl">Provenance:</label>
                        <input type="text" id="provenance_entry_gpl" name="provenance" required>
                        @error('provenance')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="livraison_entry_gpl">Numéro Bordereau Livraison:</label>
                        <input type="text" id="livraison_entry_gpl" name="livraison" required>
                        @error('livraison') {{-- Changed $errors->has('label') to $errors->has('livraison') --}}
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="matricule_entry_gpl">Matricule du véhicule:</label>
                        <input type="text" id="matricule_entry_gpl" name="matricule" required>
                        @error('matricule') {{-- Changed $errors->has('label') to $errors->has('matricule') --}}
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormEntryGpl">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingEntryGpl" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <div id="entry-pleine" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entrée de Bouteilles Pleines</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="entry-pleine-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="origin_entry_pleine">Type d'opération:</label>
                        <select name="origin" id="origin_entry_pleine">
                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="region">Région</option> {{-- Corrected spelling --}}
                            <option value="production">Production</option>
                            <option value="stock_initial">Stock initial</option>
                        </select>
                        @error('origin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label>Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight" id="weight_6kg_pleine"> <label for="weight_6kg_pleine">6kg</label>
                            <input type="radio" value="12.5" name="weight" id="weight_12_5kg_pleine"> <label for="weight_12_5kg_pleine">12.5kg</label>
                            <input type="radio" value="50" name="weight" id="weight_50kg_pleine"> <label for="weight_50kg_pleine">50 kg</label>
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="qty_entry_pleine">Quantité :</label>
                        <input type="number" id="qty_entry_pleine" name="qty" required>
                        @error('qty')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="label_entry_pleine">Libellé:</label>
                        <input type="text" id="label_entry_pleine" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bord_entry_pleine">Bordereau :</label>
                        <input type="text" id="bord_entry_pleine" name="bord" required>
                        @error('bord')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormEntryPleine">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingEntryPleine" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <div id="entry-vides" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entrée de Bouteilles Vides</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="entry-vides-form" action="{{ route('saveBottleMove', ['action' => 'entry', 'state' => 0]) }}" method="post">
                    @csrf
                    <div class="modal-champs">
                        <label for="origin_entry_vides">Type d'opération:</label>
                        <select name="origin" id="origin_entry_vides">
                            @if (Auth::user()->region != 'central')
                                <option value="achat">Fournisseur</option>
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            @if (Auth::user()->region == 'central')
                                <option value="achat">Achat</option>
                                <option value="retour reepreuve">Retour sur réépreuve</option> {{-- Corrected spelling --}}
                            @endif
                            <option value="region">Région</option>
                            <option value="production">Production</option>
                            <option value="stock_initial">Stock initial</option>
                        </select>
                        @error('origin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label>Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight" id="weight_6kg_vides"> <label for="weight_6kg_vides">6kg</label>
                            <input type="radio" value="12.5" name="weight" id="weight_12_5kg_vides"> <label for="weight_12_5kg_vides">12.5kg</label>
                            <input type="radio" value="50" name="weight" id="weight_50kg_vides"> <label for="weight_50kg_vides">50 kg</label>
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="qty_entry_vides">Quantité :</label>
                        <input type="number" id="qty_entry_vides" name="qty" required>
                        @error('qty')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="label_entry_vides">Libellé:</label>
                        <input type="text" id="label_entry_vides" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bord_entry_vides">Bordereau :</label>
                        <input type="text" id="bord_entry_vides" name="bord" required>
                        @error('bord')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormEntryVides">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingEntryVides" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <div id="entry-accessory" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Entrée d'Accessoire</h1> {{-- Corrected spelling --}}
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="entry-accessory-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="title_entry_accessory">Type d'accessoire:</label> {{-- Corrected spelling --}}
                        <select name="title" id="title_entry_accessory">
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->title }}">{{ $accessory->title }}</option>
                            @endforeach
                        </select>
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="operation_entry_accessory">Type d'opération:</label>
                        <select name="operation" id="operation_entry_accessory">
                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="stock_initial">Stock initial</option>
                        </select>
                        @error('operation')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="qty_entry_accessory">Quantité :</label>
                        <input type="number" id="qty_entry_accessory" name="qty" required>
                    </div>
                    @error('qty')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <div class="modal-champs">
                        <label for="label_entry_accessory">Libellé:</label>
                        <input type="text" id="label_entry_accessory" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bord_entry_accessory">Bordereau :</label>
                        <input type="text" id="bord_entry_accessory" name="bord" required>
                        @error('bord')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormEntryAccessory">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingEntryAccessory" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    {{-- SORTIES FORMULAIRES --}}
    <div id="outcome-gpl" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de GPL Vrac</h1> {{-- Corrected spelling: Outcome -> Sortie --}}
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="outcome-gpl-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="citerne_outcome_gpl">Type de citerne:</label>
                        <select name="citerne" id="citerne_outcome_gpl">
                            @foreach ($vrac as $vrac_item) {{-- Renamed $vrac to $vrac_item to avoid variable shadowing --}}
                                <option value="{{ $vrac_item->name }}">{{ $vrac_item->name }} - ({{ $vrac_item->type }})</option>
                            @endforeach
                        </select>
                        @error('citerne')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="operation_outcome_gpl">Type d'opération:</label>
                        <select name="operation" id="operation_outcome_gpl">
                            <option value="stock_initial">Stock initial</option>
                        </select>
                        @error('operation')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="qty_outcome_gpl">Quantité <span class="text-red-500">*</span></label>
                        <div>
                            <input type="number" id="qty_outcome_gpl" name="qty" required>
                            @error('qty')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="label_outcome_gpl">Libellé:</label>
                        <input type="text" id="label_outcome_gpl" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormOutcomeGpl">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingOutcomeGpl" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <div id="outcome-pleine" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Bouteilles Pleines</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="outcome-pleine-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="origin_outcome_pleine">Type d'opération:</label>
                        <select name="origin" id="origin_outcome_pleine">
                            @foreach ($regions as $region )
                                <option value={{$region->region}}>{{$region->region}}</option>
                            @endforeach
                            <option value="pertes">Pertes</option>
                            @if (Auth::user()->region != 'central')
                                <option value="magasin central">MAGASIN CENTRAL</option>
                                <option value="client">Client</option>
                            @endif
                        </select>
                        @error('origin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label>Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight" id="weight_6kg_outcome_pleine"> <label for="weight_6kg_outcome_pleine">6kg</label>
                            <input type="radio" value="12.5" name="weight" id="weight_12_5kg_outcome_pleine"> <label for="weight_12_5kg_outcome_pleine">12.5kg</label>
                            <input type="radio" value="50" name="weight" id="weight_50kg_outcome_pleine"> <label for="weight_50kg_outcome_pleine">50 kg</label>
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="qty_outcome_pleine">Quantité :</label>
                        <input type="number" id="qty_outcome_pleine" name="qty" required>
                        @error('qty')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="label_outcome_pleine">Libellé:</label>
                        <input type="text" id="label_outcome_pleine" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bord_outcome_pleine">Bordereau :</label>
                        <input type="text" id="bord_outcome_pleine" name="bord" required>
                        @error('bord')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormOutcomePleine">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingOutcomePleine" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <div id="outcome-vides" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie de Bouteilles Vides</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="outcome-vides-form" action="{{ route('saveBottleMove', ['action' => 'outcome', 'state' => 0]) }}" method="POST">
                    @csrf
                    <div class="modal-champs">
                        <label for="origin_outcome_vides">Type d'opération:</label>
                        <select name="origin" id="origin_outcome_vides">
                            @if (Auth::user()->region != 'central')
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="production">Production</option>
                            <option value="reepreuve">Réépreuve</option> {{-- Corrected spelling --}}
                            <option value="consigne">Consigne</option>
                            <option value="pertes">Pertes</option>
                        </select>
                        @error('origin')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label>Type de bouteilles:</label>
                        <div>
                            <input type="radio" value="6" name="weight" id="weight_6kg_outcome_vides"> <label for="weight_6kg_outcome_vides">6kg</label>
                            <input type="radio" value="12.5" name="weight" id="weight_12_5kg_outcome_vides"> <label for="weight_12_5kg_outcome_vides">12.5kg</label>
                            <input type="radio" value="50" name="weight" id="weight_50kg_outcome_vides"> <label for="weight_50kg_outcome_vides">50 kg</label>
                        </div>
                    </div>
                    <div class="modal-champs">
                        <label for="qty_outcome_vides">Quantité :</label>
                        <input type="number" id="qty_outcome_vides" name="qty" required>
                        @error('qty')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="label_outcome_vides">Libellé:</label>
                        <input type="text" id="label_outcome_vides" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bord_outcome_vides">Bordereau :</label>
                        <input type="text" id="bord_outcome_vides" name="bord" required>
                        @error('bord')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormOutcomeVides">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingOutcomeVides" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <div id="outcome-accessory" class="modals">
        <center>
            <div class="modal-active">
                <div class="modal-head">
                    <h1>Sortie d'Accessoire</h1>
                    <span class="close-modal" role="button" aria-label="Fermer la modale">X</span>
                </div>
                <span class="success text-green-500" role="status"></span>
                <span class="errors text-red-500" role="alert"></span>
                <form id="outcome-accessory-form">
                    @csrf
                    <div class="modal-champs">
                        <label for="title_outcome_accessory">Type d'accessoire:</label>
                        <select name="title" id="title_outcome_accessory">
                            @foreach ($accessories as $accessory)
                                <option value="{{ $accessory->title }}">{{ $accessory->title }}</option>
                            @endforeach
                        </select>
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="operation_outcome_accessory">Type d'opération:</label>
                        <select name="operation" id="operation_outcome_accessory">
                            @if (Auth::user()->region != 'central')
                                <option value="client">Client</option>
                                <option value="magasin central">MAGASIN CENTRAL</option>
                            @endif
                            <option value="stock_initial">Stock initial</option>
                        </select>
                        @error('operation')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="qty_outcome_accessory">Quantité :</label>
                        <input type="number" id="qty_outcome_accessory" name="qty" required>
                        @error('qty')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="label_outcome_accessory">Libellé:</label>
                        <input type="text" id="label_outcome_accessory" name="label" required>
                        @error('label')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-champs">
                        <label for="bord_outcome_accessory">Bordereau :</label>
                        <input type="text" id="bord_outcome_accessory" name="bord" required>
                        @error('bord')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-validation">
                        <button type="reset">Annuler</button>
                        <button type="submit" id="submitFormOutcomeAccessory">Créer</button> {{-- Unique ID --}}
                    </div>
                    <div id="loadingOutcomeAccessory" style="display:none;" class="text-yellow-500">Enregistrement...</div> {{-- Unique ID --}}
                </form>
            </div>
        </center>
    </div>

    <footer class="mt-10 w-full secondary flex justify-between p-4 text-white rounded-md">
        <div>
            <a href="">Contacter</a>
            <a href="">Aide</a>
            <a href="">Mentions Légales</a> {{-- Corrected spelling --}}
        </div>
        <p>&copy; 2024</p>
    </footer>

    <script type="module">
        $(function() {
            // Initialize DataTable
            $('table').DataTable();

            // Function to handle modal opening
            function openModal(modalId) {
                $(modalId).addClass("modals-active").removeClass("modals");
            }

            // Function to handle modal closing
            function closeModal(modalId) {
                $(modalId).addClass("modals").removeClass("modals-active");
            }

            // Universal close modal functionality
            $(".close-modal").on("click", function(e) {
                e.preventDefault();
                $(this).closest(".modals-active").addClass("modals").removeClass("modals-active");
            });

            // Form deployment actions
            $("#activate-transmit-form").on("click", function(e) {
                e.preventDefault();
                openModal("#transmit-form");
            });

            $("#activate-broute-pdf-form").on("click", function(e) {
                e.preventDefault();
                openModal("#broute-form");
            });

            $("#activate-releves-pdf-form").on("click", function(e) {
                e.preventDefault();
                openModal("#releves-pdf-form");
            });

            $("#activate-receives-pdf-form").on("click", function(e) {
                e.preventDefault();
                openModal("#recieves-pdf-form");
            });

            $("#activate-pdf-form").on("click", function(e) {
                e.preventDefault();
                openModal("#pdf-form");
            });

            $("#activate-form-entry-gpl").on("click", function(e) {
                e.preventDefault();
                openModal("#entry-gpl");
            });

            $("#activate-form-entry-vide").on("click", function(e) {
                e.preventDefault();
                openModal("#entry-vides");
            });

            $("#activate-form-entry-pleine").on("click", function(e) {
                e.preventDefault();
                openModal("#entry-pleine");
            });

            $("#activate-form-entry-accessory").on("click", function(e) {
                e.preventDefault();
                openModal("#entry-accessory");
            });

            // The #activate-form-outcome-gpl was commented out in HTML, keeping it commented for now
            // $("#activate-form-outcome-gpl").on("click", function(e) {
            //     e.preventDefault();
            //     openModal("#outcome-gpl");
            // });

            $("#activate-form-outcome-vide").on("click", function(e) {
                e.preventDefault();
                openModal("#outcome-vides");
            });

            $("#activate-form-outcome-pleine").on("click", function(e) {
                e.preventDefault();
                openModal("#outcome-pleine");
            });

            $("#activate-form-outcome-accessory").on("click", function(e) {
                e.preventDefault();
                openModal("#outcome-accessory");
            });

            // Helper function for AJAX form submission
            function handleFormSubmission(formId, submitBtnId, loadingId, url, resetForm = true) {
                $(formId).submit(function(e) {
                    e.preventDefault();
                    const submitButton = $(submitBtnId);
                    const loadingIndicator = $(loadingId);
                    const successMessage = $(formId).closest('.modal-active').find('.success');
                    const errorMessage = $(formId).closest('.modal-active').find('.errors');

                    if (submitButton.prop("disabled")) {
                        return;
                    }
                    submitButton.prop("disabled", true);
                    loadingIndicator.show();
                    successMessage.text(""); // Clear previous messages
                    errorMessage.text(""); // Clear previous messages

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.error) {
                                errorMessage.text(response.error);
                            } else {
                                successMessage.text(response.success);
                                if (resetForm) {
                                    $(formId)[0].reset();
                                }
                                // Reload relevant sections of the page
                                $("table").load(location.href + " table");
                                $(".info").load(location.href + " .info");
                            }
                            submitButton.prop("disabled", false);
                            loadingIndicator.hide();
                            setTimeout(() => {
                                successMessage.text("");
                                errorMessage.text("");
                            }, 3000); // Increased timeout for better visibility
                        },
                        error: function(xhr) {
                            submitButton.prop("disabled", false);
                            loadingIndicator.hide();
                            // Parse validation errors from Laravel if they exist
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                let errorMessages = '';
                                for (let key in xhr.responseJSON.errors) {
                                    errorMessages += xhr.responseJSON.errors[key].join(', ') + '<br>';
                                }
                                errorMessage.html(errorMessages);
                            } else {
                                errorMessage.text("An unexpected error occurred.");
                            }
                            setTimeout(() => {
                                errorMessage.text("");
                            }, 5000); // Longer timeout for errors
                        }
                    });
                });
            }

            // Attach form submissions
            handleFormSubmission("#entry-gpl-form", "#submitFormEntryGpl", "#loadingEntryGpl", "{{ route('MoveGpl') }}");
            handleFormSubmission("#entry-pleine-form", "#submitFormEntryPleine", "#loadingEntryPleine", "{{ route('saveBottleMove', ['action' => 'entry', 'state' => 1]) }}");
            handleFormSubmission("#entry-vides-form", "#submitFormEntryVides", "#loadingEntryVides", "{{ route('saveBottleMove', ['action' => 'entry', 'state' => 0]) }}");
            handleFormSubmission("#entry-accessory-form", "#submitFormEntryAccessory", "#loadingEntryAccessory", "{{ route('saveAccessoryMove', ['action' => 'entry']) }}");
            handleFormSubmission("#transmit-gpl-form", "#submitFormTransmit", "#loadingTransmit", "{{ route('Depotage') }}");
            handleFormSubmission("#outcome-pleine-form", "#submitFormOutcomePleine", "#loadingOutcomePleine", "{{ route('saveBottleMove', ['action' => 'outcome', 'state' => 1]) }}");
            handleFormSubmission("#outcome-vides-form", "#submitFormOutcomeVides", "#loadingOutcomeVides", "{{ route('saveBottleMove', ['action' => 'outcome', 'state' => 0]) }}");
            handleFormSubmission("#outcome-accessory-form", "#submitFormOutcomeAccessory", "#loadingOutcomeAccessory", "{{ route('saveAccessoryMove', ['action' => 'outcome']) }}");
            // For PDF generation forms, they are typically direct submissions or might require special handling if they generate files directly
            // The current setup for PDF forms uses direct POST, so they don't need AJAX handlers here unless the behavior changes.
            // Ensure the submit buttons for PDF forms have unique IDs if they are to be managed by AJAX.
        });
    </script>
</body>

</html>