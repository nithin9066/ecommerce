@php
use App\Http\Controllers\cartController;
use Illuminate\Support\Arr;
$cartobj = new cartController;

    $secure = ['cart','checkout','payment','guest-checkout'];
    $currentRoute = Arr::last(explode('/',url()->current()));
    
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="logoo.png">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/nav.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
    <link rel="icon" type="image/x-icon" href="/favicon.png" />
    <!--<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>-->
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    @yield('script')
    @yield('title')
    @yield('style')
    <style>
        .product:after {
            content: "";
            display: block;
            width: 10%;
            margin: 10px auto;
            background-color: #475569;
            height: 2px;
        }
        ::-webkit-scrollbar {
            width: 5px;
            height: 1px;
        }
        ::-webkit-scrollbar-track {
            background: #0112fe17; 
        }
        ::-webkit-scrollbar-thumb {
            background: #0112fe8c;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0112fe9c; 
        }
    </style>
    <script>
        $(document).ready(function () {
                $("#cart").text(localStorage.getItem("cart"));
                $(".item").click(function () {
                    const cart = $("#cart").text();
                    if (cart != "") {
                        const count =
                            parseInt(localStorage.getItem("cart")) + 1;
                        localStorage.setItem("cart", count);
                        $("#cart").text(count);
                    } else {
                        $("#cart").text(1);
                        localStorage.setItem("cart", 1);
                    }
                });
            });
    </script>
</head>
<body class="lg:pb-auto pb-10">
    @include('sweetalert::alert')
    @include('includes.login')
    @include('includes.signup')
    @include('includes.header')

    @yield('content')

    @if (!in_array($currentRoute, $secure))
        @include('includes.footer')
    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/guest.js"></script>
    <script src="/sw.js"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    <script>
        AOS.init();
    </script>
    @yield('bodyscript')
    @yield('guestscript')
</body>

</html>