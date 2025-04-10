<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stargas SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet" />
</head>

<body class="">



    <center>
        <h3>{{ $service }} :{{ $region }} </h3>
        <h4> FICHE DE STOCK GLOBAL BOUTEILLES GAZ
            {{ $type }} KG du {{ $depart }} au {{ $fin }}</h4>

    </center>

    <center>
        <h1><u> Bouteilles {{$etat = 0? "VIDE(S)":"PLEINE(S)"}}</u></h1>
    </center>
    <table class="table-1">
        <thead>
            <tr>
                <th colspan="3">MVT DU STOCK TOTAL</th>
                <th><b>DATES</b></th>
                <th><b>LIBELLES</b></th>
                <th colspan="3">MVT EN MAGASIN DES BOUTEILLES {{$etat = 0? "VIDE(S)":"PLEINE(S)"}}</th>
            </tr>
            <tr>
                <th>Achats</th>
                <th>Cons.</th>
                <th>Pertes</th>
                <th>

                </th>
                <th> </th>
                <th>ENTREES</th>
                <th>SORTIES</th>
                <th><b>STOCKS</b></th>
            </tr>
        </thead>
        <?php
        $total_achat = 0;
        $total_consigne1 = 0;
        $total_perte1 = 0; ?>
        <tr class="head-color">
            <td></td>
            <td></td>
            <td></td>
            <td>

            </td>
            <td> </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <?php $sommeEntryV = 0;
        $sommeOutcomeV = 0; ?>
        <tbody>
            <?php
            if($etat = 0){
            $bouteille= $bouteille_vides;
            }else{
                $bouteille= $bouteille_pleines;
            }?>
            @foreach ( $bouteille as $data)
                <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                    <td>

                        {{ $data->origin == 'achat' ? $data->qty : 0 }}
                    </td>

                    <td>
                        <?php
                        if ($data->origin == 'consigne') {
                            $total_consigne1 += $data->qty;
                        } elseif ($data->origin == 'pertes') {
                            $total_perte1 += $data->qty;
                        } elseif ($data->origin == 'achat') {
                            $total_achat += $data->qty;
                        }
                        ?>
                        {{ $data->origin == 'consigne' ? $data->qty : 0 }}
                    </td>
                    <td>
                        {{ $data->origin == 'pertes' ? $data->qty : 0 }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->label }}</td>
                    <?php
                    if ($data->entree) {
                        $sommeEntryV += $data->qty;
                    } else {
                        $sommeOutcomeV += $data->qty;
                    }
                    ?>
                    <td>{{ $data->entree >= 1 ? $data->qty : 0 }}</td>
                    <td>{{ $data->entree == 0 ? $data->qty : 0 }}</td>
                    <td>{{ $data->stock }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>{{ $total_achat }}</b></td>
                <td><b>{{ $total_consigne1 }}</b></td>
                <td><b>{{ $total_perte1 }}</b></td>
                <td colspan="2"> <b>Total Mouvements</b></td>
                <td><b>{{ $sommeEntryV }}</b></td>
                <td><b>{{ $sommeOutcomeV }}</b></td>
                <td>/</td>
            </tr>
        </tbody>
    </table>


</body>

</html>
