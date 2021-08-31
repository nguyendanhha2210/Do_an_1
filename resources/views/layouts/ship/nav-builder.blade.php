<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{ route('ship.home') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>
                            Overview</span>
                    </a>
                </li>
                

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Đơn Hàng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('ship.order.list') }}">Danh sách đơn hàng</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
