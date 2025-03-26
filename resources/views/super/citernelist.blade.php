@extends('Layouts.appLayout')
@section('content') 
<h1 class="text-xl font-bold text-center">liste des Citernes</h1>
<div class="w-full gap-4 flex justify-end mb-4">
    <button class="bg-orange-400 text-white font-bold p-4 rounded-md "><a href="{{ route('addCiterns') }}">Ajouter une
            Citerne</a></button>

</div>
</table> 
<table class="w-full bg-orange-200 border-separate p-4 rounded-md text-center table-2">
    <thead class="font-bold">
        <tr>
            <td>Nom</td>
            <td>Type</td>
            <td>action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($citernes as $citerne)
            <tr>
                <td>{{ $citerne->name }}</td>
                <td>{{ $citerne->type }}</td>
                <td><i id="{{ $citerne->id }}"
                        class="delete-citern px-4 p-1 rounded-md bg-red-500 text-white cursor-pointer fa-solid fa-trash"></i>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
    <script>
        $(document).ready(function() {
            $(".delete").on("click", function(e) {
                e.preventDefault()
                articleId = $(this).attr('id');
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
                            url: "deleteArticle/" + articleId,
                            dataType: "json",
                            data: {
                                "id": articleId,
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




            $(".delete-citern").on("click", function(e) {
                e.preventDefault()
                citernId = $(this).attr('id');
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
                            url: "deleteCitern/" + citernId,
                            dataType: "json",
                            data: {
                                "id": citernId,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire("element supprime avec success", "",
                                    "success");
                                $('.table-2').load(" .table-2")
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                });

            })
        })
    </script>
</div>

@endsection