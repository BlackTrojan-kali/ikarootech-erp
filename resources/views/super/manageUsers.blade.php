@extends('Layouts.appLayout')
@section('content')
    <div class="mt-8 p-2">
        <div class=" mb-2 flex justify-end p-3 ">
            <a href="{{ route('addUser') }}" class="p-4 bg-green-400 text-white font-bold">Ajouter un Utilisateur</a>
        </div>
        <table id="table-1" class="w-full table-auto bg-slate-200 border-separate p-2">
            <thead class="text-center font-bold py-12">
                <tr class="">
                    <td>id</td>
                    <td>Nom d'utilisateur</td>
                    <td>Email</td>
                    <td>role</td>
                    <td>region</td>
                    <td>actions</td>
                </tr>
            <tbody>
                @foreach ($users as $user)
                    <tr class="mb-5 text-center">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->region }}</td>
                        <td>
                            <a href="{{ route('editUser', $user->id) }}"
                                class="px-4 p-1 rounded-md bg-blue-500 text-white"><i class="fa-solid fa-edit"></i></a>
                            <a id={{ $user->id }} class="delete px-4 p-1 rounded-md bg-red-500 text-white"><i
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
                            url: "deleteUser/" + userId,
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
