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
                @foreach ($releve as $data)
                    <tr class="hover:bg-blue-400 hover:text-white hover:cursor-pointer">
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->citerne }}</td>
                        <td>{{ $data->stock_theo }}</td>
                        <td>{{ $data->stock_rel }}</td>
                        <td>{{ $data->stock_rel - $data->stock_theo }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td>{{ $data->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </center>
</body>

</html>
