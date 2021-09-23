<header class="header fixed-top clearfix">
    <div class="brand">
        <a href="{{ route('admin.home') }}" class="logo">
            Admin
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <div class="nav notify-row" id="top_menu">
        <ul class="nav top-menu">
            @if (isset($goBack))
            <a class="d-flex align-items-center  btn btn-link pl-0" href="{{ $goBack }}">
                <img src="/backend/icon/Back.svg" alt="">
            </a>
        @endif

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
        <ul class="nav pull-right top-menu">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{ '/frontend/images/avatar-1.png' }}" />
                    <span class="username">
                        Admin
                    </span>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li>
                        <a href="/admin/adminer"><i class="fa fa-suitcase"></i>Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.logout') }}"><i class="fa fa-key"></i>Đăng Xuất</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>
