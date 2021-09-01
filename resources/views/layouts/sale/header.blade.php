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
                </div>
                <div class="ht-right">
                    @if (Auth::guard('sales')->id())
                        <a href="{{ URL::to('sale/logout') }}" class="login-panel"><i
                                class="fa fa-user"></i>Logout</a>
                    @else
                        <a href="{{ URL::to('/login') }}" class="login-panel"><i
                                class="fa fa-user"></i>Login</a>
                    @endif

                    <div class="lan-selector">
                        <select class="language_drop" name="countries" id="countries" style="width:300px;">
                            <option value='yt' data-image="{{ '/frontend/images/flag-1.jpg' }}" data-imagecss="flag yt"
                                data-title="English">English</option>
                            <option value='yu' data-image="{{ '/frontend/images/flag-2.jpg' }}" data-imagecss="flag yu"
                                data-title="Bangladesh">German </option>
                        </select>
                    </div>
                    <div class="top-social">
                        <a href="#"><i class="ti-facebook"></i></a>
                        <a href="#"><i class="ti-twitter-alt"></i></a>
                        <a href="#"><i class="ti-linkedin"></i></a>
                        <a href="#"><i class="ti-pinterest"></i></a>
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
                                <img src="{{ '/frontend/images/logoweb.png' }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <div class="input-group">
                                <input type="text" placeholder="What do you need?">
                                <button type="button"><i class="ti-search"></i></button>
                                
                                {{-- <div class="col-sm-5">
                                    <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="POST">
                                        {{csrf_field()}}
                                    <div class="search_box">
            
                                        <input type="text" style="width: 60%;margin-right: 5px" name="keywords_submit" id="keywords" placeholder="Tìm kiếm sản phẩm"/>
                                       <div id="search_ajax"></div>
            
                                       <input type="submit" style="margin-top:0;color:#666" name="search_items" class="btn btn-primary btn-sm" value="Tìm kiếm">
            
                                    </div>
                                    </form>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <span>1</span>
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="#">
                                    <i class="icon_bag_alt"></i>
                                    <?php
                                    $cart = Session::get('cart');
                                    if ($cart != null) { ?>
                                    <span>!</span>
                                    <?php }
                                    ?>

                                </a>
                                <div class="cart-hover">
                                    @if (Session::get('cart') == true)
                                        @php
                                            $total = 0;
                                        @endphp
                                        <div class="select-items">
                                            <table>
                                                <tbody>
                                                    @foreach (Session::get('cart') as $key => $cart)
                                                        @php
                                                            $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                            $total += $subtotal;
                                                        @endphp
                                                        <tr>
                                                            <td class="si-pic"><img width="40px;" height="50px;"
                                                                    src="{{ URL::to('uploads/' . $cart['product_image']) }}"
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
                                        <div class="select-total">
                                            <span>Tổng tiền :</span>
                                            <h5>{{ number_format($total, 0, ',', '.') }}đ</h5>
                                        </div>
                                    @endif
                                    <div class="select-button">
                                        <a href="{{ URL::to('/view-cart') }}" class="primary-btn view-card">VIEW
                                            CARD</a>

                                        <a href="{{ URL::to('sale/checkout') }}"
                                            class="primary-btn checkout-btn">CHECK OUT</a>

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
                                <li><a href="{{ URL::to('/contact') }}">Contact</a></li>
                                <li>
                                    @if (Auth::guard('sales')->id())
                                        <a href="{{ URL::to('sale/profile') }}">Profile</a>
                                    @else
                                        <a href="{{ URL::to('/register') }}">Register</a>
                                    @endif
                                </li>
                                <li>
                                    @if (Auth::guard('sales')->id())
                                        <a href="{{ URL::to('sale/logout') }}">Logout</a>
                                    @else
                                        <a href="{{ URL::to('/login') }}">Login</a>
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
                        @if (isset($breadcrumbs))
                            @foreach ($breadcrumbs as $key => $breadcrumb)
                                @if ($key != count($breadcrumbs) - 1)
                                    <span><a href="{{ URL::to('/') }}"><i class="fa fa-home"></i> Home</a><a
                                            href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></span>
                                @else
                                    <span><a href="{{ URL::to('/') }}"><i class="fa fa-home"></i> Home</a></span>
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
