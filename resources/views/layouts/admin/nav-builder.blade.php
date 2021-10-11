<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{ route('admin.home') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>
                            Overview
                        </span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Statistical</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.statistical.invoice') }}">Invoice Statistics</a></li>
                        <li><a href="{{ route('admin.statistical.product') }}">Product Statistics</a></li>
                        <li><a href="{{ route('admin.statistical.rating') }}">Rating Statistics</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="{{ route('admin.replyComment.list') }}">
                        <i class="fa fa-book"></i>
                        <span>Reply Comment</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ route('admin.warehouse.list') }}">
                        <i class="fa fa-book"></i>
                        <span>Warehouse</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('admin.order.list') }}">
                        <i class="fa fa-book"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('admin.product.list') }}">
                        <i class="fa fa-book"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('admin.coupon.list') }}">
                        <i class="fa fa-book"></i>
                        <span>Coupons</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Posts</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.post.list') }}">Post List</a></li>
                        <li><a href="{{ route('admin.categorypost.list') }}">Posts Category</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Account</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.user.list') }}">User</a></li>
                        <li><a href="{{ route('admin.shipper.list') }}">Shipper</a></li>
                        <li><a href="{{ route('admin.admin.list') }}">Admin</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Product Option</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.description.list') }}">Descriptions</a></li>
                        <li><a href="{{ route('admin.weight.list') }}">Weights</a></li>
                        <li><a href="{{ route('admin.type.list') }}">Types</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
