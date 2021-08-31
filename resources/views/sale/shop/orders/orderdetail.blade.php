@extends('layouts.sale.layout')
@section('content')
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <th>Người Đặt</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Ghi chú</th>
                                    <th>Thanh toán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $shipping->name }}</td>
                                    <td>{{ $shipping->address }}</td>
                                    <td>{{ $shipping->phone }}</td>
                                    <td>{{ $shipping->email }}</td>
                                    <td>{{ $shipping->shipping_notes }}</td>
                                    <td>
                                        @if ($shipping->shipping_method == 0) Chuyển khoản
                                        @else
                                            Tiền mặt @endif
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Mã Giảm</th>
                                    <th>Phí Ship </th>
                                    <th>Đơn Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                    $total = 0;
                                @endphp
                                @foreach ($order_details as $key => $details)
                                    @php
                                        $i++;
                                        $subtotal = $details->product_price * $details->product_sales_quantity;
                                        $total += $subtotal;
                                    @endphp
                                    <tr class="color_qty_{{ $details->product_id }}">

                                        <td><i>{{ $i }}</i></td>
                                        <td>{{ $details->product_name }}</td>
                                        <td>
                                            @if ($details->product_coupon != 'no')
                                                {{ $details->product_coupon }}
                                            @else
                                                Không mã
                                            @endif
                                        </td>
                                        <td>{{ number_format($details->product_feeship, 0, ',', '.') }}đ</td>
                                        <td>{{ number_format($details->product_price, 0, ',', '.') }}đ</td>
                                        <td>{{ $details->product_sales_quantity }} </td>
                                        <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="12">
                                        @php
                                            $total_coupon = 0;
                                        @endphp
                                        @if ($coupon_condition == 1)
                                            @php
                                                $total_after_coupon = ($total * $coupon_number) / 100;
                                                echo 'Tổng giảm :' . number_format($total_after_coupon, 0, ',', '.') . '</br>';
                                                $total_coupon = $total + $details->product_feeship - $total_after_coupon;
                                            @endphp
                                        @else
                                            @php
                                                echo 'Tổng giảm :' . number_format($coupon_number, 0, ',', '.') . 'k' . '</br>';
                                                $total_coupon = $total + $details->product_feeship - $coupon_number;
                                                
                                            @endphp
                                        @endif
                                        Phí ship : {{ number_format($details->product_feeship, 0, ',', '.') }}đ</br>
                                        Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
