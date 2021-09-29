<!DOCTYPE html>

<head>
    <title>Fresh Mama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <link rel="icon" href="/uploads/title_web.ico"> {{-- logo tap web --}}

    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('backend/css/style-responsive.css') }}" rel="stylesheet" />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{ asset('backend/css/font.css') }}" type="text/css" />
    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/css/morris.css') }}" type="text/css" />
    <!-- calendar -->
    <link rel="stylesheet" href="{{ asset('backend/css/monthly.css') }}">
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{ asset('backend/js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('backend/js/raphael-min.js') }}"></script>
    <script src="{{ asset('backend/js/morris.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend/bootstrap-4.0.0-dist/css/bootstrap.min.css') }}"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        ._vue-flash-msg-body__text {
            position: absolute;
            top: 43%;
            left: 50%;
            width: 100%;
            transform: translate(-25%, -25%);
            font-size: 19px;
        }

    </style>

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
    <div id="adminApp">
        <main>
            <section id="container">
                @include('layouts.admin.nav-builder')
                @include('layouts.admin.header')
                <section id="main-content">
                    <section class="wrapper">
                        @yield('content')
                    </section>
                </section>
            </section>
        </main>
    </div>
    <script src="{{ asset('js/adminApp.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>

    {{-- <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script> --}}

    <script type="text/javascript">
        $('.order_status').change(function() {
            var id = $(this).data('order_id');
            var values = $(this).val();
            var _token = $('input[name="_token"]').val();
            var tong_tien = $('.tong-tien').val();
            quantity = [];
            $("input[name='product_sales_quantity']").each(function() {
                quantity.push($(this).val());
            });

            order_weight=[];
            $("input[name='order_weight']").each(function() {
                order_weight.push($(this).val());
            });

            //lay ra product id
            order_product_id = [];
            $("input[name='order_product_id']").each(function() {
                order_product_id.push($(this).val());
            });
            $.ajax({
                url: '{{ url('admin/update-order-status') }}',
                method: 'post',
                data: {
                    tong_tien: tong_tien,
                    order_product_id: order_product_id,
                    order_weight: order_weight,
                    quantity: quantity,
                    id: id,
                    values: values,
                    _token: _token
                },
                success: function(data) {
                    alert('Cập nhật trạng thái đơn hàng thành công');
                    location.reload();
                }
            });
        });
    </script>

</body>

</html>
