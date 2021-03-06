@extends('layouts.sale.layout')
@section('content')
    <section style="background-color: #e9edf0">
        <div class="container ">
            <div class="row">
                <stepper-purchase :data="2"></stepper-purchase>
                <div class="col-lg-12 mt-3 mb-5">
                    <div class="cart-table" style="background-color: white;padding: 17px">
                        <form action="{{ URL::to('/update-cart') }}" method="POST">
                            @csrf
                            <table>
                                @if (Session::get('storeNumber') == true)
                                    @foreach (Session::get('storeNumber') as $key => $cart)
                                        <span style="color:red;display: block;" class="text-center">The number of
                                            {{ $cart['nameProduct'] }} left in stock is : {{ $cart['quantityStock'] }}
                                            kg</span>
                                    @endforeach
                                @endif

                                @if (Session::get('message') == true)
                                    <span style="color:red;display: block;" class="text-center">
                                        {{ Session::get('message') }}</span>
                                @endif

                                <thead>
                                    <tr style="background-color: #e9edf0">
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                        <th>Into Money</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (Session::get('cart') == true)
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach (Session::get('cart') as $key => $cart)
                                            @php
                                                $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td style="text-align: center" class="cart-pic first-row"><img width="70px"
                                                        height="80px"
                                                        src="{{ URL::to('uploads/products/' . $cart['product_image']) }}"
                                                        alt="">
                                                </td>
                                                <td style="text-align: center" class="cart-title first-row">
                                                    <h5>{{ $cart['product_name'] }}</h5>
                                                </td>
                                                <td>
                                                    <input
                                                        style="text-align: center;padding-top: 28px;border: none;color: red;"
                                                        class="p-price first-row" readonly
                                                        name="cart_wei[{{ $cart['session_id'] }}]"
                                                        value="{{ $cart['product_weight'] }}">
                                                </td>

                                                <td style="text-align: center" class="p-price first-row">
                                                    {{ number_format($cart['product_price'], 0, ',', '.') }}??</td>
                                                <td style="text-align: center" class="qua-col first-row">
                                                    <div class="quantity">
                                                        <div class="pro-qty" style="width:72px">
                                                            <input class="cart_quantity" type="number" min="1"
                                                                name="cart_qty[{{ $cart['session_id'] }}]"
                                                                value="{{ $cart['product_qty'] }}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="text-align: center" class="total-price first-row">
                                                    {{ number_format($subtotal, 0, ',', '.') }}??</td>
                                                <td style="text-align: center" class="close-td first-row"><a
                                                        href="{{ URL::to('/del-product-cart/' . $cart['session_id']) }}"><i
                                                            class="ti-close"></i></a></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="6" style="font-size: 18px;">
                                                @php
                                                    echo 'L??m ??n th??m s???n ph???m v??o gi??? h??ng !';
                                                @endphp
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                            <table>
                                <tr style="transform: translate(0%, 20%);">
                                    <td><a href="{{ URL::to('/shop') }}" class="primary-btn">Shopping</a></td>
                                    <td><input class="primary-btn" type="submit" value="Update" name="update_qty"></td>
                                    <td><a class="primary-btn" href="{{ URL::to('/del-all-product') }}">Delete
                                            All</a></td>
                                    <td colspan="2">
                                        @if (Session::get('coupon'))
                                            <a class="primary-btn" href="{{ URL::to('/unset-coupon') }}">Delete
                                                Coupon</a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="row" style="background-color: white">
                        <div class="col-lg-4 text-center">
                            <div class="discount-coupon mt-3" style="padding-top: 17px;background-color: #e9edf0;">
                                <h6>Discount Code</h6>
                                <form action="{{ URL::to('/check-coupon') }}" method="POST" class="coupon-form">
                                    @csrf
                                    <input type="text" class="form-control" name="coupon"
                                        placeholder="Nh???p m?? gi???m gi?? ...">
                                    <button type="submit" class="site-btn coupon-btn" name="check_coupon">Apply</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout" style="padding-top: 17px;
                                                                padding-bottom: 17px;">
                                <ul style="background-color: #e9edf0">
                                    <li class="subtotal">Total Amount
                                        :<span>
                                            @if (Session::get('cart') == true)
                                                {{ number_format($total, 0, ',', '.') }}??
                                                <?php
                                                $totalPriceBill = Session::get('totalPriceBill');
                                                $totalPriceBill[] = [
                                                    'money' => $total,
                                                ];
                                                Session::put('totalPriceBill', $totalPriceBill);
                                                ?>
                                            @endif

                                        </span></li>
                                    @if (Session::get('coupon'))
                                        <li class="subtotal">
                                            @foreach (Session::get('coupon') as $key => $cou)
                                                @if ($cou['coupon_condition'] == 1)
                                                    {{ Session::forget('totalPriceBill') }} {{-- qu??n session l???y t???ng ti???n --}}
                                                    Discount Code : <span>{{ $cou['coupon_number'] }} %</span>
                                                    <p>
                                                        @php
                                                            $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                        @endphp
                                        <li class="subtotal">Total has decreased :
                                            <span>{{ number_format($total_coupon, 0, ',', '.') }}??</span>

                                        </li>
                                        </p>
                                        <p>
                                            <li class="subtotal">
                                                Total has decreased :
                                                <span>{{ number_format($total - $total_coupon, 0, ',', '.') }}</span>
                                                <?php
                                                $totalPriceBill = Session::get('totalPriceBill');
                                                $totalPriceBill[] = [
                                                    'money' => $total - $total_coupon,
                                                ];
                                                Session::put('totalPriceBill', $totalPriceBill);
                                                ?>
                                            </li>
                                        </p>
                                    @elseif($cou['coupon_condition'] == 2)
                                        {{ Session::forget('totalPriceBill') }} {{-- qu??n session l???y t???ng ti???n --}}
                                        Discount Code : <span> {{ $cou['coupon_number'] }} k</span>
                                        <p>
                                            @php
                                                $total_coupon = $total - $cou['coupon_number'];
                                            @endphp
                                        </p>
                                        <p>
                                            <li class="subtotal">
                                                Total has decreased :
                                                <span>{{ number_format($total_coupon, 0, ',', '.') }}??</span>
                                                <?php
                                                $totalPriceBill = Session::get('totalPriceBill');
                                                $totalPriceBill[] = [
                                                    'money' => $total_coupon,
                                                ];
                                                Session::put('totalPriceBill', $totalPriceBill);
                                                ?>
                                            </li>
                                        </p>
                                    @endif
                                    @endforeach
                                    </li>
                                    @endif

                                    <form method="post" action="{{ URL::to('sale/order-place') }}">
                                        @csrf
                                        <div class="payment-options">
                                            <span>
                                                <label><input name="payment_option" checked value="1" type="radio"> Thanh
                                                    to??n khi
                                                    nh???n h??ng </label> <i class=" fa fa-money"></i> <br>
                                            </span>
                                            <span>
                                                <label><input name="payment_option" value="3" type="radio"> Thanh to??n qua
                                                    VnPay</label><br>
                                            </span>
                                            @if (Session::get('cart') == true)
                                                <button type="submit" class="proceed-btn check_out"
                                                    style="width: 100%;">Order</button>
                                            @else
                                                <a class="proceed-btn check_out"
                                                    href="{{ URL::to('/shop') }}">Shopping</a>
                                            @endif
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
