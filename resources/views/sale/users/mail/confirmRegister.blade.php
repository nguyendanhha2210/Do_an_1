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
            <h3>Thông báo khách hàng từ <a target="_blank" href="https://fresh-mama.herokuapp.com/">FreshMama.com</a>
            </h3>
        </div>
        <div class="container">
            <p class="code">Vui lòng Click <a href="{{url('register-confirm/'.$email)}}"> tạiđây </a>.</p>
            <b>Để xác nhận việc đăng kí của bạn là chính xác !</b>
        </div>
    </div>
</body>

</html>
