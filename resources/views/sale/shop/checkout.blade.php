@extends('layouts.sale.layout')
@section('content')
    <section class="checkout-section spad">
        <div class="container">
            <form action="#" class="checkout-form">
                <div class="row">
                    <div class="col-lg-6">
                        <checkout-cart></checkout-cart>
                    </div>
                    <div class="col-lg-6">
                        <div class="place-order">
                            <h4>Thông tin đơn hàng</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>
                                    @if (Session::get('cart') == true)
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach (Session::get('cart') as $key => $cart)
                                            @php
                                                $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                $total += $subtotal;
                                            @endphp
                                            <li class="fw-normal">{{ $cart['product_name'] }} x
                                                {{ $cart['product_qty'] }}
                                                <span>{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                                            </li>
                                        @endforeach
                                        <li class="fw-normal"><i style="font-size: 17px;color:green;">Thành Tiền</i>
                                            <span><i
                                                    style="font-size: 17px;color:green;">{{ number_format($total, 0, ',', '.') }}đ</i></span>
                                        </li>
                                        @php
                                            $totalAfter = 0;    
                                        @endphp
                                        @if (Session::get('coupon'))
                                            <li class="fw-normal">
                                                @foreach (Session::get('coupon') as $key => $cou)
                                                    @if ($cou['coupon_condition'] == 1)
                                                        Mã Giảm : <span>{{ $cou['coupon_number'] }} %</span>
                                                        @php
                                                            $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                        @endphp
                                            <li class="fw-normal">Tổng đã giảm :
                                                <span>{{ number_format($total_coupon, 0, ',', '.') }}đ</span>
                                            </li>
                                            <li class="fw-normal" style="font-size: 18px;color:red;">
                                                Tổng đã giảm :
                                                @php
                                                    $totalAfter = $total - $total_coupon;   
                                                @endphp
                                                <span>{{ number_format($totalAfter , 0, ',', '.') }} đ</span>
                                            </li>
                                        @elseif($cou['coupon_condition'] == 2)
                                            Mã Giảm :
                                            <span>{{ number_format($cou['coupon_number'], 0, ',', '.') }}đ</span>
                                            @php
                                                $totalAfter  = $total - $cou['coupon_number'];
                                            @endphp

                                            <li class="fw-normal"><i style="font-size: 18px;color:red;">Tổng đã giảm
                                                    :</i>
                                                <span><i
                                                        style="font-size: 18px;color:red;">{{ number_format($totalAfter , 0, ',', '.') }}đ</i>
                                                </span>
                                            </li>
                                        @endif
                                    @endforeach
                                    @endif
                                    @endif
                                </ul>
                                <ul>
                                    @php
                                        $vnd_to_usd = $totalAfter / 23083;
                                    @endphp
                                    <div id="paypal-button"></div>
                                    <input type="hidden" id="vnd_to_usd" value="{{ round($vnd_to_usd, 2) }}">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
