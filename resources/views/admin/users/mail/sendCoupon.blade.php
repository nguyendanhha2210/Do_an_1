<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial;
        }

        .coupon {
            border: 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;
        }

        .container {
            padding: 2px 16px;
            background-color: #f1f1f1;
        }

        .promo {
            background: #ccc;
            padding: 3px;
        }

        .expire {
            color: red;
        }

        p.code {
            text-align: center;
            font-size: 20px;
        }

        p.expire {
            text-align: center;
        }

        h2.note {
            text-align: center;
            font-size: large;
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <div class="coupon" style="text-align: center">
        <div class="container">
            <h3>Mã khuyến mãi dành cho khách hàng từ <a target="_blank"
                    href="https://fresh-mama.herokuapp.com/">FreshMama.com</a>
            </h3>
        </div>
        <div class="container" style="background-color:white">

            <h2 class="note"><b><i>
                        @if ($coupon['condition'] == 1)
                            Giảm {{ $coupon['number'] }}%
                        @else
                            Giảm {{ number_format($coupon['number'], 0, ',', '.') }}vnđ
                        @endif
                        cho tổng đơn hàng đặt mua
                    </i></b></h2>

            <p>Quý khách đã từng mua hàng tại shop <a target="_blank" style="color:red"
                    href="https://fresh-mama.herokuapp.com/">FreshMama.com</a> nếu đã
                có tài khoản xin vui lòng <a target="_blank" style="color:red"
                    href="https://fresh-mama.herokuapp.com/login">đăng nhập</a> vào
                tài khoản để mua hàng và nhập mã code phía dưới để được giảm giá mua hàng ,xin cảm ơn quý khách.Chúc quý
                khách thật nhiều sức khỏe và bình an trong cuộc sống. </p>
        </div>
        <div class="container">
            <p class="code">Sử dụng mã code sau : <span class="promo">{{ $coupon['code'] }}</span> .
                Chúc bạn có trải nhiệm tuyệt vời tại cửa hàng !</p>
            <p class="expire">Start Day : {{ $coupon['start_date'] }} | End Day :
                {{ $coupon['end_date'] }}</p>
        </div>
    </div>
</body>

</html>
