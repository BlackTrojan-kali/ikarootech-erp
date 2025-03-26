@extends('Layouts.appLayout')
@section('content') 
<h1 class="text-xl font-bold text-center">liste des Stocks</h1>
<div class="w-full gap-4 flex justify-end mb-4">
    <button class="secondary text-white font-bold p-4 rounded-md "><a href="{{ route('add_stock') }}">Ajouter un Stock</a></button>

</div>

<table id="table-1" class="w-full table-auto bg-slate-200 border-separate p-2">
    <thead class="font-bold">
        <tr>
            <td>Article</td>
            <td>Type</td>
            <td>Poid</td>
            <td>Region</td>
            <td>Service</td>
            <td>action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($stocks as $stock)
            <tr>
                <td>

                    @if ($stock->article->title == "stargas")
                        @if ($stock->article->state == 1)
                            {{ $stock->article->weight." ".$stock->article->unity." pleine" }}
                            @else

                            {{ $stock->article->weight." ".$stock->article->unity." vide" }}
                        @endif
                        @else

                        {{ $stock->article->title}}
                    @endif
                </td>
                <td>{{ $stock->article->type }}</td>
                <td>{{ $stock->article->weight }} {{$stock->article->unity}}</td>
                <td>{{ $stock->region }}</td>
                <td>{{$stock->category}}</td>
                <td><i id="{{ $stock->id }}"
                        class="delete-citern px-4 p-1 rounded-md bg-red-500 text-white cursor-pointer fa-solid fa-trash"></i>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
    <script>
        $(document).ready(function() {
            $('table').DataTable();
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
                            url: "delete_stock/" + articleId,
                            dataType: "json",
                            data: {
                                "id": articleId,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire("element supprime avec success", "",
                                    "success");
                                $('#table-1').load(" #table-1")
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire("Changement non enregistre", "", "info");
                    }
                });

            })




            $("#table-1").on("click",".delete-citern", function(e) {
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
                            url: "delete_stock/" + citernId,
                            dataType: "json",
                            data: {
                                "id": citernId,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire("element supprime avec success", "",
                                    "success");
                                $('#table-1').load(" #table-1")
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