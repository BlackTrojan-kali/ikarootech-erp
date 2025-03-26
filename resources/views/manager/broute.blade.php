<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stargas SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @font-face {
            font-family: 'Riot';
            src: url({{ storage_path('/fonts/ProtestRiot-Regular.ttf') }}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        body {
            font-family: "Riot";
            padding: 5px;
        }

        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            font-size: 0.8rem;
        }

        th,
        tr,
        td {
            border: 1px solid black;
            padding: 4px;

        }

        .logo-section {
            position: absolute;
            top: 2px;
        }

        .head-color {
            background-color: burlywood;
            padding: 20px;
        }

        .date {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .title {
            text-align: center;
        }

        .title p {
            font-weight: bold;
            font-size: 2rem;
            padding: 5px;
            background-color: rgba(203, 154, 250, 0.747);
            border: 2px solid black;
            border-radius: 12px;
            text-align: center;
        }

        .bold {
            font-weight: bold;
            background-color: rgba(90, 69, 42, 0.404);
        }

        .table-2 {
            border: none !important;
        }

        .details p {
            background-color: rgb(235, 230, 230);
            padding: 20px;
            border: 4px solid black
        }

        .footer {
            background-color: rgb(0, 140, 255);
            color: white;
            width: 100%;
            padding: 5px;
            text-align: center;
        }
    </style>
    <br>
    <br><br>
    <br>
    <br><br><br>
    <br><br>
    <div class="logo-section">
        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo.png'))) }}"
            width="100px">
        <p>
        </p>
    </div>
    <div class="date">
        {{ $broute->depart }},{{ $broute->created_at }} <br>
        No:{{ strtoupper(substr($broute->region, 0, 2)) }}{{ $broute->id }}
    </div>
    <center>

        <div class="title">
            <p>
                BORDEREAU DE ROUTE
            </p>
        </div>
        <table>
            <tr>
                <td colspan="2" class="bold">Immatriculation du véhicule :</td>
                <td colspan="2">{{ $broute->matricule }}</td>
            </tr>
            <tr>
                <td class="bold"> Ville de départ :</td>
                <td>{{ $broute->depart }}</td>
                <td class="bold">Ville d’arrivée :
                </td>
                <td>{{ $broute->arrivee }}</td>
            </tr>
            <tr>
                <td class="bold">Date de départ </td>
                <td>{{ $broute->date_depart }}</td>
                <td class="bold">Date de retour :</td>
                <td>{{ $broute->date_arrivee }}</td>
            </tr>
            <tr>
                <td class="bold">Nom du chauffeur :</td>
                <td>{{ $broute->nom_chauffeur }}</td>
                <td class="bold">N° Permis de conduire :</td>
                <td>{{ $broute->permis }}</td>
            </tr>
            <tr>
                <td class="bold">Aide chauffeur :</td>
                <td>{{ $broute->aide_chauffeur }}</td>
                <td class="bold">Contacts :</td>
                <td>{{ $broute->contact }}</td>
            </tr>
        </table>
        <div class="details">
            <h1>Details :</h1>
            <p>
                {{ $broute->details }}
            </p>
        </div>
    </center>
    <br><br>
    <table class="table-2">
        <tr>
            <td>
                <div class="signature-1">
                    <table>
                        <tr>
                            <td class="bold" style="padding:2px; text-align:center;">Nom date et visa
                                Chauffeur
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                <br><br>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
            <td></td>
            <td>
                <div class="signature-2 ">
                    <table>
                        <tr>
                            <td class="bold" style="padding:2px; text-align:center;">Nom date et Visa
                                Responsable
                            </td>
                        </tr>
                        <tr>
                            <td>

                                <br>
                                <br><br>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br><br>
<!--    <div class="footer">
        <p>
            Société Anonyme au Capital de 400 000 000 F CFA <br>
            Siège social à la Zone Industrielle MAGZI - Yaoundé (Mvan) · B.P. : 17159 Yaoundé <br>
            Tél. : +237 655 38 00 00 / 698 45 31 32 / 698 47 08 30 · R.C. N° : YAO/2012/B/323 ·Contrib. N° :
            M051200042049E <br>
            E-mail : info@stargascameroun.com / stargascameroun@gmail.com /Site Web : www.stargascameroun.com
        </p>
    </div>-->
</body>

</html>
