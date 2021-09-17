@extends('layouts.sale.layout')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="{{ 'frontend/images/21.jpg' }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span style="color: green">Cuốn sách là một giấc mơ mà bạn cầm trong tay !</span>
                            <h1 style="color: green">Black friday</h1>
                            <p style="color: green">Dành cho mọi khác hàng vocher mua hàng với giá ưu đãi từ cửa hàng !</p>
                            <a href="{{ URL::to('/shop') }}" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="{{ 'frontend/images/23.jpg' }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span style="color: green">Sách hay, cũng như bạn tốt, ít và được lựa chọn; chọn lựa càng nhiều,
                                thưởng thức càng nhiều !</span>
                            <h1 style="color: green">Black friday</h1>
                            <p style="color: green">Dành cho mọi khác hàng vocher mua hàng với giá ưu đãi từ cửa hàng !</p>
                            <a href="{{ URL::to('/shop') }}" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img style="height:330px;" class="lazy" data-src="{{ 'frontend/images/3.jpg' }}" alt="">
                        <div class="inner-text">
                            <h4>Mơ Dẻo</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img style="height:330px;" class="lazy" data-src="{{ 'frontend/images/4.jpg' }}" alt="">
                        <div class="inner-text">
                            <h4>Dâu Tây</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img style="height:330px;" class="lazy" data-src="{{ 'frontend/images/5.jpg' }}" alt="">
                        <div class="inner-text">
                            <h4>Nho Khô</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Women Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ 'frontend/images/6.jpg' }}">
                        <h2>Mix</h2>
                        <a href="{{ URL::to('/shop') }}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1" style="background-color: #e9edf0">
                    <div class="filter-control">
                        <ul>
                            <li class="active">Sản Phẩm Nổi Bật</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($featureProduct as $key)
                            <form>
                                @csrf
                                <input type="hidden" value="{{ $key->id }}"
                                    class="cart_product_id_{{ $key->id }}">
                                <input type="hidden" value="{{ $key->name }}"
                                    class="cart_product_name_{{ $key->id }}">
                                {{-- <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$pro->product_id}}"> --}}
                                <input type="hidden" value="{{ $key->images }}"
                                    class="cart_product_image_{{ $key->id }}">
                                <input type="hidden" value="{{ $key->price }}"
                                    class="cart_product_price_{{ $key->id }}">
                                <input type="hidden" value="1" class="cart_product_qty_{{ $key->id }}">

                                {{-- Lấy cho sp yêu thích --}}
                                <input type="hidden" id="wishlist_productname{{ $key->id }}"
                                    value="{{ $key->name }}">
                                <input type="hidden" id="wishlist_productprice{{ $key->id }}"
                                    value="{{ number_format($key->price) . ' đ' }}">
                                <input type="hidden" id="wishlist_productimage{{ $key->id }}"
                                    src="{{ URL::to('uploads/' . $key->images) }}" value="{{ $key->images }}">
                                <a type="hidden" id="wishlist_producturl{{ $key->id }}"
                                    href="{{ URL::to('/product-detail/' . $key->id) }}"></a>
                                {{-- Lấy cho sp yêu thích --}}

                                <div class="product-item" style="background-color:white">
                                    <div class="pi-pic">
                                        <img height="320px" src="{{ URL::to('uploads/' . $key->images) }}" alt="">
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <a class="btn btn-default" id="{{ $key->id }}"
                                                onclick="add_wistlist(this.id)"><i class=" icon_heart_alt"></i></a>
                                        </div>
                                        <ul>
                                            <li class="w-icon active">
                                                <a class="btn btn-default add-to-cart"
                                                    data-id_product="{{ $key->id }}" name="add-to-cart"><i
                                                        class="fa fa-shopping-basket"></i></a>
                                            </li>
                                            <li class="w-icon active">
                                                <a href="{{ URL::to('/product-detail/' . $key->id) }}"><i
                                                        class="fa fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pi-text"
                                        style="padding-top: 19px !important; border: 0.5px solid #e9edf0">
                                        <a href="#" style="transform: translate(0%, -34%); font-size: 21px">
                                            <h5 style="">
                                                {{ $key->name }}
                                            </h5>
                                        </a>
                                        <div style="color: red; transform: translate(-27%, 53%)">
                                            <u style="
                                                      font-size: 13px;
                                                      display: -webkit-inline-box;
                                                      transform: translate(0%, -13%);
                                                    ">đ</u>
                                            <span style="font-size: 19px">{{ number_format($key->price) }}</span>
                                        </div>
                                        <div class="da-ban" style="
                                                    transform: translate(32%, -47%);
                                                    font-size: 14px;
                                                    color: dimgray;
                                                  ">
                                            <span>Đã bán {{ $key->product_sold }}</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Women Banner Section End -->

    <!-- Deal Of The Week Section Begin-->
    <section class="deal-of-week set-bg spad " data-setbg="{{ 'frontend/images/15.jpg' }}">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Sale off 50% tại MâyBook</h2>
                    <p>Chúng ta sẽ trở thành gì phụ thuộc vào điều chúng ta đọc sau khi tất cả<br /> các thầy cô giáo đã
                        xong việc với chúng ta. Trường học vĩ đại nhất chính là sách vở. </p>
                    <div class="product-price">
                        1.688.000 VNĐ
                        <span>/20 Cuốn Tự Chọn</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>56</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>12</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>40</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>52</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="{{ URL::to('/shop') }}" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section>
    <!-- Deal Of The Week Section End -->

    <!-- Man Banner Section Begin -->
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8" style="background-color: #e9edf0">
                    <div class="filter-control">
                        <ul>
                            <li class="active">Sản Phẩm Bán Chạy</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($sellingProduct as $key)
                            <form>
                                @csrf
                                <input type="hidden" value="{{ $key->id }}"
                                    class="cart_product_id_{{ $key->id }}">
                                <input type="hidden" value="{{ $key->name }}"
                                    class="cart_product_name_{{ $key->id }}">
                                {{-- <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$pro->product_id}}"> --}}
                                <input type="hidden" value="{{ $key->images }}"
                                    class="cart_product_image_{{ $key->id }}">
                                <input type="hidden" value="{{ $key->price }}"
                                    class="cart_product_price_{{ $key->id }}">
                                <input type="hidden" value="1" class="cart_product_qty_{{ $key->id }}">

                                <div class="product-item" style="background-color:white">
                                    <div class="pi-pic">
                                        <img height="320px;" src="{{ URL::to('uploads/' . $key->images) }}" alt="">
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <a class="btn btn-default add-to-favorite"
                                                data-id_product="{{ $key->id }}" name="add-to-favorite"><i
                                                    class=" icon_heart_alt"></i></a>
                                        </div>
                                        <ul>
                                            <li class="w-icon active">
                                                <a class="btn btn-default add-to-cart"
                                                    data-id_product="{{ $key->id }}" name="add-to-cart"><i
                                                        class="fa fa-shopping-basket"></i></a>

                                            </li>
                                            <li class="w-icon active">
                                                <a href="{{ URL::to('/product-detail/' . $key->id) }}`"><i
                                                        class="fa fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pi-text"
                                        style="padding-top: 19px !important; border: 0.5px solid #e9edf0">
                                        <a href="#" style="transform: translate(0%, -34%); font-size: 21px">
                                            <h5 style="">
                                                {{ $key->name }}
                                            </h5>
                                        </a>
                                        <div style="color: red; transform: translate(-27%, 53%)">
                                            <u style="
                                                      font-size: 13px;
                                                      display: -webkit-inline-box;
                                                      transform: translate(0%, -13%);
                                                    ">đ</u>
                                            <span style="font-size: 19px">{{ number_format($key->price) }}</span>
                                        </div>
                                        <div class="da-ban" style="
                                                    transform: translate(32%, -47%);
                                                    font-size: 14px;
                                                    color: dimgray;
                                                  ">
                                            <span>Đã bán {{ $key->product_sold }}</span>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="{{ 'frontend/images/9.jpg' }}">
                        <h2>Mix</h2>
                        <a href="{{ URL::to('/shop') }}">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Man Banner Section End -->

    <!-- Instagram Section Begin -->
    <div class="instagram-photo">
        <div class="insta-item set-bg" data-setbg="{{ 'frontend/images/9.jpg' }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ 'frontend/images/6.jpg' }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ 'frontend/images/7.jpg' }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ 'frontend/images/10.jpg' }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ 'frontend/images/11.jpg' }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ 'frontend/images/12.jpg' }}">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">colorlib_Collection</a></h5>
            </div>
        </div>
    </div>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Posts</h2>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color: #e9edf0">
                @foreach ($post as $key)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-latest-blog" style="background-color: white;margin-top: 27px;">
                            <a href="{{ URL::to('blog/' . $key->id . '/detail') }}">
                                <img style="height: 260px" src="{{ URL::to('uploads/' . $key->images) }}" alt="">
                            </a>

                            <div class="latest-text" style="padding-left: 16px;
                                    padding-bottom: 5px;">
                                <div class="tag-list">
                                    <div class="tag-item">
                                        <i class="fa fa-calendar-o"></i>
                                        {{ date($key->created_at) }}
                                    </div>
                                    <div class="tag-item">
                                        <i class="fa fa-comment-o"></i>
                                        5
                                    </div>
                                </div>

                                <a href="{{ URL::to('blog/' . $key->id . '/detail') }}">
                                    <h4>{{ $key->title }}</h4>
                                </a>
                                <p>{{ $key->title }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img class="lazy" data-src="{{ 'frontend/images/icon-1.png' }}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Free Shipping</h6>
                                <p>For all product</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img class="lazy" data-src="{{ 'frontend/images/icon-2.png' }}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Delivery On Time</h6>
                                <p>If good have prolems</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img class="lazy" data-src="{{ 'frontend/images/icon-3.png' }}" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Secure Payment</h6>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->
@endsection
