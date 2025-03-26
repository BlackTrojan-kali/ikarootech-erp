<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stargas SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
<style>
       @font-face {
    font-family: 'Riot';
    src: url({{storage_path('/fonts/ProtestRiot-Regular.ttf')}}) format("truetype");
    font-weight: 400; 
    font-style: normal; 
    }
    body{
        font-family: "Riot";
        padding:5px;
    }
    table{
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }
    th{
        font-size: 0.8rem;
    }
    th,tr,td{
        border: 1px solid black;
        padding: 4px;
        
    }
    .logo-section{
        position: absolute;
        top: 2px;
    }
    .head-color{
        background-color:burlywood;
        padding: 20px;
    }
</style>
<br>
<br><br>
<br>
<br><br><br>
<br><br>
<div class="logo-section">
    <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/logo.png')))}}" width="100px"> 
    <p>
        <b>{{ env('COMPANIE_NAME') }}</b><br>
        <b>B.P:</b>{{ env('COMPANIE_ADDRESS') }} <br>
        <b>Tél:</b>{{ env('COMPANIE_CANTACT_1') }} <br>
        <b>Email:</b> {{ env('COMPANIE_EMAIL_1') }} <br>
    </p>
</div>
<center>
<h3>Region:{{ Auth::user()->region }} </h3>
<h4> FICHE HISTORIQUES RELEVE GPL VRAC </h4>

<table>
    <thead>
        <th>No:</th>
        <th>Citerne</th>
        <th>Stock Theorique</th>
        <th>Stock Releve</th>
        <th>Ecart</th>
        <th>Date De Creation</th>
        <th>Date De Modification</th>
    </thead>
    <tbody>
        @foreach ($releve as $data )
        <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
            <td>{{ $data->id }}</td>
            <td>{{ $data->citerne }}</td>
            <td>{{ $data->stock_theo }}</td>
            <td>{{ $data->stock_rel}}</td>
            <td>{{ $data->stock_rel -$data->stock_theo }}</td>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->updated_at }}</td>
        </tr>     
        @endforeach
    </tbody>
</table>
</center>
</body>
</html>