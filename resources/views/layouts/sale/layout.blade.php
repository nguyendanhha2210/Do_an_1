<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fresh Mama</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    {{-- Thông báo khi thêm giỏ --}}
    <link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script>
    {{-- Thông báo khi thêm giỏ --}}

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

    {{-- Buộc phải thêm khi dùng Vue JS --}}
    {{-- <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" /> --}}
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
        @yield('content')
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                // var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/add-to-cart') }}',
                    method: 'POST',
                    data: {
                        id: cart_product_id,
                        name: cart_product_name,
                        images: cart_product_image,
                        price: cart_product_price,
                        _token: _token
                    },
                    success: function() {
                        swal({
                                title: "Do you want to continue？",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                cancelButtonText: "Xem tiếp",
                                confirmButtonText: "Đi đến giỏ hàng !",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{ url('/view-cart') }}";
                            });
                    }
                });
            });
        });
    </script>
    {{-- <script type="text/javascript">
        $('#keywords').keyup(function() {
            var query = $(this).val();

            if (query != '') {
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('/autocomplete-ajax') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });

            } else {

                $('#search_ajax').fadeOut();
            }
        });

        $(document).on('click', '.li_search_ajax', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        });
    </script> --}}
</body>
</html>
