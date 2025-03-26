@extends('Layouts.appLayout')
@section('content')
    <div class="mt-8 p-2">
        <div class=" mb-2 flex justify-end p-3 ">
            <a href="{{ route('create-client') }}" class="p-4 bg-green-400 text-white font-bold">Ajouter un Client</a>
        </div>
        <table id="table-1" class="w-full table-auto bg-slate-200 border-separate p-2">
            <thead class="text-center font-bold py-12">
                <tr class="">
                    <td>id</td>
                    <td>Nom Client</td>
                    <td>Prenom</td>
                    <td>Telephone</td>
                    <td>Categorie</td>
                    <td>Region</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
            <tbody>
                @foreach ($clients as $client)
                    <tr class="mb-5 ">
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->prenom }}</td>
                        <td>{{ $client->numero }}</td>
                        <td>{{ $client->Clientcat->name }}</td>
                        <td>{{ $client->region }}</td>
                        <td>{{ $client->created_at }}</td>
                        <td>

                            <a id={{ $client->id }} href={{ route('modify-client', ['id' => $client->id]) }}
                                class="px-4 p-1 rounded-md bg-blue-500 text-white"><i class="fa-solid fa-edit"></i></a>
                            <a id={{ $client->id }} class="delete px-4 p-1 rounded-md bg-red-500 text-white"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                <br>
            </tbody>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function() {

            $('table').DataTable();
            $("#table-1").on("click", ".delete", function(e) {
                e.preventDefault()
                userId = $(this).attr('id');
                Swal.fire({
                    title: "Etes vous sures ? cette operation est irreversible",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Supprimer",
                    denyButtonText: `Annuler`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "/delete-client/" + userId,
                            dataType: "json",
                            data: {
                                "id": userId,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire("element supprime avec success", "",
                                    "success");
                                $('table').load(" table")
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                });

            })
        })
    </script>
@endsection
