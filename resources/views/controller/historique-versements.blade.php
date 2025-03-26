@extends('Layouts.controllerLayout')
@section('content')
    <center>
        <h1 class="p-2 mt-5 font-bold text-2xl">Historique des Versements

        </h1>
        <div class=" flex w-full gap-3">
            <!-- The whole future lies in uncertainty: live immediately. - Seneca -->

            <table class="history scroll mt-10 w-1/2 border-2 border-collapse border-gray-400 text-center ">
                <thead class="p-3 bg-gray-500 text-white">
                    <td colspan="6" class="text-center">
                        {{ env('COMPANIE_BANK_1') }}
                    </td>
                    <tr>
                        <td>
                            date
                        </td>
                        <td>
                            GPL
                        </td>
                        <td>
                            Consigne
                        </td>
                        <td>
                            Montant Versee
                        </td>
                        <td>
                            Numerode bordereau
                        </td>
                        <td>commentaire</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ventes as $vente)
                        <tr class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                            <td>{{ $vente->created_at }}</td>
                            <td>
                                {{ $vente->montant_gpl }}
                            </td>
                            <td>
                                {{ $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->montant_gpl + $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->bordereau }}
                            </td>
                            <td> {{ $vente->commentaire }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="history scroll mt-10 w-1/2 border-2 border-collapse border-gray-400 text-center ">
                <thead class="p-3 bg-gray-500 text-white">
                    <td colspan="6" class="text-center">
                        {{ env('COMPANIE_BANK_2') }}
                    </td>
                    <tr>
                        <td>date</td>
                        <td>
                            GPL
                        </td>
                        <td>
                            Consigne

                        </td>
                        <td>
                            Montant Versee
                        </td>

                        <td>
                            Numerode bordereau
                        </td>
                        <td>
                            commentaire
                        </td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ventes2 as $vente)
                        <tr class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                            <td>{{ $vente->created_at }}</td>
                            <td>
                                {{ $vente->montant_gpl }}
                            </td>
                            <td>
                                {{ $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->montant_gpl + $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->bordereau }}
                            </td>
                            <td>
                                {{ $vente->commentaire }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>

            <table class="history scroll mt-10 w-1/2 border-2 border-collapse border-gray-400 text-center ">
                <thead class="p-3 bg-gray-500 text-white">
                    <td colspan="6" class="text-center">
                        CAISSE
                    </td>
                    <tr>
                        <td>date</td>
                        <td>
                            GPL
                        </td>
                        <td>
                            Consigne

                        </td>
                        <td>
                            Montant Versee
                        </td>

                        <td>
                            Numerode bordereau
                        </td>
                        <td>
                            commentaire
                        </td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ventes3 as $vente)
                        <tr class="hover:text-white hover:bg-blue-400 hover:cursor-pointer">
                            <td>{{ $vente->created_at }}</td>
                            <td>
                                {{ $vente->montant_gpl }}
                            </td>
                            <td>
                                {{ $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->montant_gpl + $vente->montant_consigne }}
                            </td>
                            <td>
                                {{ $vente->bordereau }}
                            </td>
                            <td>
                                {{ $vente->commentaire }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </center>
@endsection
