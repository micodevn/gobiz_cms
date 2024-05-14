<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="#" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="https://cms3.edupia.vn/assets/images/brands/logo-Edupia-blue-400x96.png" alt="" height="30">
                            </span>
                        <span class="logo-lg">
                                <img src="https://cms3.edupia.vn/assets/images/brands/logo-Edupia-blue-400x96.png" alt="" height="45">
                            </span>
                    </a>

                    <a href="#" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="https://cms3.edupia.vn/assets/images/brands/logo-Edupia-white-400x96.png" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="https://cms3.edupia.vn/assets/images/brands/logo-Edupia-white-400x96.png" alt="" height="45">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="https://cms3.edupia.vn/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">admin</span>
                                    </span>
                                </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Anna!
                            <form id="logout-form" action="/logout" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></button>
                            </form>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box bg-white">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('/images/logo.png')}}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{asset('/images/logo.png')}}" alt="" height="45">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('/images/logo.png')}}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{asset('/images/logo.png')}}" alt="" height="45">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                @include('layouts.menu')
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
