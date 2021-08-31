<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <a href="{{ route('admin.home') }}" class="logo">
            Admin
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <ul class="nav top-menu">
            @if (isset($breadcrumbs))
                @foreach ($breadcrumbs as $key => $breadcrumb)
                    @if ($key != count($breadcrumbs) - 1)
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                    @endif
                @endforeach
            @endif

        </ul>
    </div>

    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{ 'image/3.png' }}" />
                    <span class="username">
                        Admin
                    </span>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li>
                        <a href="#"><i class="fa fa-suitcase"></i>Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-cog"></i> Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.logout') }}"><i class="fa fa-key"></i>Đăng Xuất</a>
                    </li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>
