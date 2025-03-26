@extends("Layouts.comLayout")
@section("content")
<style>
    td,th{
        border: 1px solid black;
        padding: 8px;
    }
    </style>
    <h1 class="text-center p-2">
        STOCK GLOBAL DES 
        @if($weight == 12)
        EMBALLAGES    DE
        12.5
        @elseif($weight == 0)
        ACCESSOIRES 
        @else
        {{ $weight }}KG
        @endif

    </h1>
<div class="w-full flex">
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
    <table class="border-2 border-black">
        <thead class="bg-gray-500 text-white ">
            <th colspan="3">MVT DU STOCK TOTAL</th>
            <th>Dates</th>
            <th>Libelles</th>
            <th colspan="3">MVT EN MAGASIN DES BOUTEILLES VIDES</th>
       
        </thead>
        <tr class="border border-black">
            <td>Achats</td>
            <td>Ventes</td>
            <td>Pertes</td>
            <td>
    
            </td>
            <td> </td>
            <td>ENTREES</td>
            <td>SORTIES</td>
            <td>STOCKS</td>
        </tr> <tr class="border border-black">
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
        <tbody>
                
            @foreach ($bouteille_vides as $data )
            
            <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                <td>
                   {{ $data->origin == "ventes" ? $data->qty:0 }}
                </td>
                <td>
                    {{ $data->origin == "achat" ? $data->qty:0 }}</td>
                <td>
                    {{ $data->origin == "pertes" ? $data->qty:0 }}</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->label }}</td>
                <td>{{ $data->entree ? $data->qty :0 }}</td>
                <td>{{ $data->sortie ? $data->qty :0 }}</td>
                <td>{{ $data->stock }}</td>
                
        </tr>
            @endforeach
        
    </tbody>
</table>
<table  class="border-2 border-black">
    <thead  class="bg-gray-500 text-white ">
        
        <th>Dates</th>
        <th colspan="3">MVT EN MAGASIN DES BOUTEILLES PLEINES</th>
    </thead>
    <tr>
        
        <td></td>
        <td>ENTREES</td>
        <td>SORTIES</td>
        <td>STOCKS</td>
    </tr>
    <tr>
        
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tbody>   
            @foreach ($bouteille_pleines as $data ) 
            <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
            <td>{{ $data->created_at }}</td>
                <td>{{ $data->entree ? $data->qty :0 }}</td>
                <td>{{ $data->sortie ? $data->qty :0 }}</td>
                <td>{{ $data->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
