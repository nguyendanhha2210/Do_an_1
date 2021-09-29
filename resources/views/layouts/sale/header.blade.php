    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class=" fa fa-envelope"></i>
                        danhha221020@gmail.com
                    </div>
                    <div class="phone-service">
                        <i class=" fa fa-phone"></i>
                        +65 11.188.888
                    </div>
                    <div class="share-service">
                        <div id="fb-root"></div>
                        <div class="fb-share-button" data-href="https://fresh-mama.herokuapp.com/" data-layout="button"
                            data-size="small"><a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u=https://fresh-mama.herokuapp.com/"
                                class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    </div>

                </div>
                <div class="ht-right">
                    @if (Auth::guard('sales')->id())
                        <a href="{{ URL::to('sale/logout') }}" class="login-panel"><i
                                class="fa fa-lock"></i>Logout</a>
                    @else
                        <a href="{{ URL::to('/login') }}" class="login-panel"><i
                                class="fa fa-sign-in"></i>Login</a>
                    @endif

                    <div class="lan-selector">
                        <select class="language_drop" name="countries" id="countries" style="width:300px;">
                            <option value='yt' data-image="{{ '/frontend/images/flag-1.jpg' }}"
                                data-imagecss="flag yt" data-title="English">English</option>
                            <option value='yu' data-image="{{ '/frontend/images/flag-2.jpg' }}"
                                data-imagecss="flag yu" data-title="Bangladesh">German </option>
                        </select>
                    </div>


                    <div class="top-social">
                        <a href="https://www.facebook.com/Mekhoebexinh02"><img
                                style="width: 27px; height: 21px;transform: translate(11%, -8%);"
                                src="{{ '/frontend/images/fb.png' }}" alt=""></a>
                        <a
                            href="https://www.sendo.vn/shop/fresh-mama?fbclid=IwAR3tWlCBasdebaIOqqRRh8PmPmBfPUQnIH5rXNFAcbldGHvgGPeRHn5TGn4"><img
                                style="width: 27px; height: 21px;transform: translate(11%, -8%);"
                                src="{{ '/frontend/images/sendo.png' }}" alt=""></a>
                        <a
                            href="https://shopee.vn/shop/227054554/?fbclid=IwAR2ZW6JvJH3sC4r_YsvntvaW8NxT00HnmJ4CnEd0uAmJEbtl8Ot45VcEr1I"><img
                                style="width: 27px; height: 21px;transform: translate(11%, -8%);"
                                src="{{ '/frontend/images/shoppee.jpg' }}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="{{ URL::to('/') }}">
                                <img style="width: 100%;height: 24px;" src="{{ '/frontend/images/logoweb.png' }}"
                                    alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <product-search></product-search>
                    </div>
                    <div class="col-lg-2 text-right col-md-2">
                        <ul class="nav-right">
                            <li class="cart-icon">
                                <a href="#">
                                    <img style="width: 27px; height: 21px;transform: translate(11%, -8%);"
                                        src="{{ '/frontend/images/view.png' }}" alt="">
                                    <?php
                                    $viewed = Session::get('viewed');
                                    if ($viewed != null) { ?>
                                    <span>{{ count(Session::get('viewed')) }}</span>
                                    <?php }
                                    ?>
                                </a>
                                @if (Session::get('viewed') == true)
                                    <div class="cart-hover cart-hover-1" style="background-color: #e9edf0">
                                        <div class="select-items">
                                            <table>
                                                <tbody>
                                                    @foreach (Session::get('viewed') as $key => $viewed)
                                                        <tr class="overflow"
                                                            style="background-color: white;border: 1px solid #e9edf0;">
                                                            <td class="si-pic pt-4"><img width="80px;" height="80px;"
                                                                    src="{{ URL::to('uploads/products/' . $viewed['product_image']) }}"
                                                                    alt=""></td>
                                                            <td class="si-text">
                                                                <div class="product-selected">
                                                                    <p>{{ number_format($viewed['product_price'], 0, ',', '.') }}đ
                                                                    </p>
                                                                    <h6>{{ $viewed['product_name'] }}</h6>
                                                                </div>
                                                            </td>
                                                            <td class="si-close">
                                                                <a
                                                                    href="{{ URL::to('/del-viewed-product/' . $viewed['session_id']) }}"><i
                                                                        class="ti-close"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                @endif
                            </li>

                            <li class="cart-icon">
                                <a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <?php
                                    $cart = Session::get('favorite');
                                    if ($cart != null) { ?>
                                    <span>{{ count(Session::get('favorite')) }}</span>
                                    <?php }
                                    ?>
                                </a>

                                @if (Session::get('favorite') == true)
                                    <div class="cart-hover cart-hover-1" style="background-color: #e9edf0">
                                        <div class="select-items">
                                            <table>
                                                <tbody>
                                                    @foreach (Session::get('favorite') as $key => $favorite)
                                                        <tr class="overflow"
                                                            style="background-color: white;border: 1px solid #e9edf0;">
                                                            <td class="si-pic"><img width="80px;" height="80px;"
                                                                    src="{{ URL::to('uploads/products/' . $favorite['product_image']) }}"
                                                                    alt=""></td>
                                                            <td class="si-text">
                                                                <div class="product-selected">
                                                                    <p>{{ number_format($favorite['product_price'], 0, ',', '.') }}đ
                                                                        x {{ $favorite['product_qty'] }}</p>
                                                                    <h6>{{ $favorite['product_name'] }}</h6>
                                                                </div>
                                                            </td>
                                                            <td class="si-close">
                                                                <a
                                                                    href="{{ URL::to('/del-favorite-product/' . $favorite['session_id']) }}"><i
                                                                        class="ti-close"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                @endif
                            </li>

                            <li class="cart-icon">
                                <a href="#">
                                    <i class="icon_bag_alt"></i>
                                    <?php
                                    $cart = Session::get('cart');
                                    if ($cart != null) { ?>
                                    <span>{{ count(Session::get('cart')) }}</span>
                                    <?php }
                                    ?>
                                </a>
                                <div class="cart-hover ">
                                    @if (Session::get('cart') == true)
                                        @php
                                            $total = 0;
                                        @endphp
                                        <div class="cartoverflow">
                                            <div class="select-items">
                                                <table>
                                                    <tbody>
                                                        @foreach (Session::get('cart') as $key => $cart)
                                                            @php
                                                                $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                                $total += $subtotal;
                                                            @endphp
                                                            <tr>
                                                                <td class="si-pic"><img width="40px;"
                                                                        height="50px;"
                                                                        src="{{ URL::to('uploads/products/' . $cart['product_image']) }}"
                                                                        alt=""></td>
                                                                <td class="si-text">
                                                                    <div class="product-selected">
                                                                        <p>{{ number_format($cart['product_price'], 0, ',', '.') }}đ
                                                                            x {{ $cart['product_qty'] }}</p>
                                                                        <h6>{{ $cart['product_name'] }}</h6>
                                                                    </div>
                                                                </td>
                                                                <td class="si-close">
                                                                    <a
                                                                        href="{{ URL::to('/del-product-cart/' . $cart['session_id']) }}"><i
                                                                            class="ti-close"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="select-total">
                                            <span>Tổng tiền :</span>
                                            <h5>{{ number_format($total, 0, ',', '.') }}đ</h5>
                                        </div>
                                    @endif
                                    <div class="select-button">
                                        <a href="{{ URL::to('/view-cart') }}" class="primary-btn view-card">VIEW
                                            CARD</a>
                                        <a class="primary-btn checkout-btn" href="{{ URL::to('/shop') }}"
                                            class="primary-btn">Shopping</a>

                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">
                                @if (Session::get('cart') == true)
                                    {{ number_format($total, 0, ',', '.') }}đ
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>PRODUCT PORTFOLIO</span>
                        <ul class="depart-hover">
                            @foreach ($type as $key => $dataType)
                                <li><a
                                        href="{{ URL::to('/choose-type/' . $dataType->id) }}">{{ $dataType->type }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li><a href="{{ URL::to('/') }}">Home</a></li>
                        <li><a href="{{ URL::to('/shop') }}">Shop</a></li>
                        <li><a href="{{ URL::to('/blog') }}">Blog</a></li>

                        <li>
                            @if (Auth::guard('sales')->id())
                                <a href="{{ URL::to('sale/manage-order') }}">Order</a>
                            @else
                                <a href="{{ URL::to('/contact') }}">Contact</a>
                            @endif
                        </li>

                        <li><a href="{{ URL::to('/view-cart') }}">Cart</a></li>
                        <li><a href="#">Account</a>
                            <ul class="dropdown">
                                <li><a href="{{ URL::to('/contact') }}"><i class="fa fa-phone"></i> Contact</a>
                                </li>
                                <li>
                                    @if (Auth::guard('sales')->id())
                                        <a href="{{ URL::to('sale/profile') }}"><i class="fa fa-info-circle"></i>
                                            Profile</a>
                                    @else
                                        <a href="{{ URL::to('/register') }}"><i class="fa fa-plus"></i>
                                            Register</a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <!-- Header End -->
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        {{-- @dd($breadcrumbs) --}}
                        @if (isset($breadcrumbs))
                            @foreach ($breadcrumbs as $key => $breadcrumb)
                                @if ($key != count($breadcrumbs) - 1)
                                    <span><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></span>
                                @else
                                    <span>{{ $breadcrumb }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->
