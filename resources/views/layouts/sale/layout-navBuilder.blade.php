<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Meat Shop">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meat Shop</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" type="text/css">
    <link rel="icon" href="/uploads/title_web.ico"> {{-- logo tap web --}}


    {{-- Buộc phải thêm khi dùng Vue JS --}}
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    {{-- <script src="{{ asset('js/app.js') }}" type="text/javascript" defer></script> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: "{{ url('/') }}", //Gọi thay cho đg dẫn http://127.0.0.1:8000
        }
    </script>
    {{-- Buộc phải thêm khi dùng Vue JS --}}
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <div id="app">
        @include('layouts.sale.header')
        <section class="product-shop spad" style="background-color: #e9edf0">
            <div class="container" style="margin-top: 17px;">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-8 order-1 order-lg-1 produts-sidebar-filter"
                        style="background-color: white;border-right:solid 1px #e9edf0">
                        @include('layouts.sale.nav-builder')
                    </div>
                    <div class="col-lg-9 order-2 order-lg-2" style="background-color: white">
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
        @include('layouts.sale.footer')
    </div>

    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <!-- Js Plugins -->
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
