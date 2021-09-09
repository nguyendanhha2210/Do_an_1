@extends('layouts.sale.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center pt-3 pb-3" style="color: green;font-weight:600">Đặt Hàng Thành Công !</h3>
                <div class="cart-table">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td>Đơn Hàng</td>
                                <td>Ngân Hàng</td>
                                <td>Mã GD VNPAY</td>
                                <td>Tổng tiền</td>
                                <td>Trạng Thái</td>
                                <td>Thời Gian</td>
                                <td>Loại Thẻ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <td>{{ $abc['vnp_TxnRef'] }}</td>
                            <td>{{ $abc['vnp_BankCode'] }}</td>
                            <td>{{ $abc['vnp_TransactionNo'] }}</td>
                            <td>{{ number_format($abc['vnp_Amount'] / 100) . ' vnđ' }}</td>
                            <td>
                                <?php
                                     if($abc['vnp_ResponseCode'] == 00) {
                                        ?>
                                <p style="color: red">Thành Công !</p>
                                <?php
                                    }
                                    ?>
                            </td>
                            <td>
                                {{ $date_time = substr($abc['vnp_PayDate'], 0, 4) . '-' . substr($abc['vnp_PayDate'], 4, 2) . '-' . substr($abc['vnp_PayDate'], 6, 2) . ' | ' . substr($abc['vnp_PayDate'], 8, 2) . ':' . substr($abc['vnp_PayDate'], 10, 2) . ':' . substr($abc['vnp_PayDate'], 12, 2) }}

                            </td>
                            <td>{{ $abc['vnp_CardType'] }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
