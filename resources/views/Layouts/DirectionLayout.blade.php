<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env("COMPANIE_NAME") }} SCMS</title>
    <link rel="icon" href="/images/logo.png">
    <link href="toastr.css" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>

<body class="mx-20">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    @if (session('success'))
        <script type="module">
            $(document).ready(function() {
                toastr.success("{{ session('success') }}")
            })
        </script>
    @elseif ($errors->has('message'))
        <script type="module">
            $(document).ready(function() {
                toastr.error("{{ $errors->first('message') }}")
            })
        </script>
    @endif
    <header class="p-4">
        <div class="w-full flex justify-between">
            <img src="/images/logo.png" class="w-32 h-auto" alt="">
            <div class="text-center mt-2">
                <p>
                    <i class="fa-solid fa-user"></i>
                    {{ Auth::user()->email }}
                </p>
                <h2 class="text-large">{{env("COMPANIE_NAME")}} Supply Chain Management System</h2>
                <h2 class="text-large">
                    Region: {{ strtoupper(Auth::user()->region) }}
                </h2>
                <h2 class="text-large">
                    Service: {{ Auth::user()->role }}
                </h2>
            </div>
            <div class=" mt-10 cursor-pointer text-center">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit">
                        <i class="fa    -solid fa-right-from-bracket text-red-800 text-4xl"></i>
                        <p> deconnexion</p>
                    </button>
                </form>
            </div>
        </div>
        <nav class="mt-2 p-2 first-letter: w-full flex  gap-5 text-white primary rounded-md">
            <div> <a href="{{ route('director-dashboard') }}"><i class="fa-solid fa-home"></i> ACCUEIL</a></div>

            <div class="font-bold cursor-pointer dropdown relative">VERSEMENTS GPL<i class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem"><a href="{{ route('globalCA') }}">Versements GPL Global</a></li>
                    @foreach ($region as $reg)
                        <li class="elem"><a
                                href="{{ route('globalCARegion', ['region' => $reg->region]) }}">Versements GPL
                                {{ $reg->region }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="font-bold cursor-pointer dropdown relative">VERSEMENTS Consigne<i
                    class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem"><a href="{{ route('globalCA-consigne') }}">Versements Cons. Global</a></li>
                    @foreach ($region as $reg)
                        <li class="elem"><a
                                href="{{ route('globalCARegion-consigne', ['region' => $reg->region]) }}">Versements
                                Cons.
                                {{ $reg->region }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">CA VENTES GPL<i class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem"><a href="{{ route('globalSalesCA') }}">CA Ventes GPL. Global</a></li>
                    @foreach ($region as $reg)
                        <li class="elem"><a href="{{ route('globalSalesCA-region', ['region' => $reg->region]) }}">CA
                                Ventes
                                GPL
                                {{ $reg->region }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">CA CONSIGNES<i class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem"><a href="{{ route('globalConsignesCA') }}">CA CONSIGNES. Global</a></li>
                    @foreach ($region as $reg)
                        <li class="elem"><a
                                href="{{ route('globalConsignesCA-region', ['region' => $reg->region]) }}">CA CONSIGNES

                                {{ $reg->region }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">Reception Bouteilles<i
                    class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem"><a href="{{ route('globalFullBottles') }}">Reception BP Global</a></li>
                    @foreach ($region as $reg)
                        <li class="elem"><a
                                href="{{ route('RegionFullBottles', ['region' => $reg->region]) }}">Reception
                                BP
                                {{ $reg->region }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="font-bold cursor-pointer dropdown relative">Reception Bouteilles<i
                    class="fa-solid fa-angle-down"></i>
                <ul class="drop-items">

                    <li class="elem"><a href="{{ route('globalEmptyBottles') }}">Reception BV Global</a></li>
                    @foreach ($region as $reg)
                        <li class="elem"><a
                                href="{{ route('RegionEmptyBottles', ['region' => $reg->region]) }}">Reception
                                BV
                                {{ $reg->region }}</a></li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </header>


    @yield('content')
    <footer class="mt-10 w-full secondary flex justify-between p-4 text-white rounded-md">
        <div>
            <a href="">Contacter</a>
            <a href="">Aide</a>
            <a href="">Mention Legal</a>
        </div>
        <p>&copy; 2024</p>
    </footer>
    <script type="module">
        $(function() {
            $('table').DataTable();
            //ACTION generate pdf produce
            $("#activate-produce-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#produce-pdf-form").hasClass("modals")) {
                    $("#produce-pdf-form").addClass("modals-active")

                    $("#produce-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#produce-pdf-form").hasClass("modals-active")) {
                    $("#produce-pdf-form").addClass("modals")
                    $("#produce-pdf-form").removeClass("modals-active")
                }
            })
            //ACTION generate pdf releves 
            $("#activate-releves-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#releves-pdf-form").hasClass("modals")) {
                    $("#releves-pdf-form").addClass("modals-active")

                    $("#releves-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#releves-pdf-form").hasClass("modals-active")) {
                    $("#releves-pdf-form").addClass("modals")
                    $("#releves-pdf-form").removeClass("modals-active")
                }
            })
            //ACTIon GENERATE PDF
            $("#activate-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#pdf-form").hasClass("modals")) {
                    $("#pdf-form").addClass("modals-active");
                    $("#pdf-form").removeClass("modals");
                }
            })
            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#pdf-form").hasClass("modals-active")) {
                    $("#pdf-form").addClass("modals");
                    $("#pdf-form").removeClass("modals-active");
                }
            })

            //ACTION generate pdf receives 
            $("#activate-receives-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#recieves-pdf-form").hasClass("modals")) {
                    $("#recieves-pdf-form").addClass("modals-active")

                    $("#recieves-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#recieves-pdf-form").hasClass("modals-active")) {
                    $("#recieves-pdf-form").addClass("modals")
                    $("#recieves-pdf-form").removeClass("modals-active")
                }
            })
            $("#activate-sales-state-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#sales-state-pdf-form").hasClass("modals")) {
                    $("#sales-state-pdf-form").addClass("modals-active")

                    $("#sales-state-pdf-form").removeClass("modals")
                }
            })

            $(".close-modal").on("click", function(e) {
                e.preventDefault()
                if ($("#sales-state-pdf-form").hasClass("modals-active")) {
                    $("#sales-state-pdf-form").addClass("modals")
                    $("#sales-state-pdf-form").removeClass("modals-active")
                }
            }) //ACTION versement historique
            $("#activate-versement-pdf-form").on("click", function(e) {
                e.preventDefault()
                if ($("#versement-pdf-form").hasClass("modals")) {
                    $("#versement-pdf-form").addClass("modals-active");
                    $("#versement-pdf-form").removeClass("modals");
                }

                $(".close-modal").on("click", function(e) {
                    e.preventDefault()
                    if ($("#versement-pdf-form").hasClass("modals-active")) {
                        $("#versement-pdf-form").addClass("modals");
                        $("#versement-pdf-form").removeClass("modals-active");
                    }
                })
            })



        })
    </script>
</body>

</html>
