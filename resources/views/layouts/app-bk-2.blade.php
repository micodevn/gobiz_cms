<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | Edupia Primary CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="stylesheet" type="text/html" href="{{asset('')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="/css/app.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.form.io/formiojs/formio.full.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/libs/treant/Treant.css">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="api_token" content="<?= session('api-token') ?>">
    <script>
        const API_TOKEN = "<?= session('api-token'); ?>";

        function getUniqueSelector(node) {
            let selector = "";
            while (node.parentElement) {
                const siblings = Array.from(node.parentElement.children).filter(
                    e => e.tagName === node.tagName
                );
                selector =
                    (siblings.indexOf(node)
                        ? `${node.tagName}:nth-of-type(${siblings.indexOf(node) + 1})`
                        : `${node.tagName}`) + `${selector ? " > " : ""}${selector}`;
                node = node.parentElement;
            }
            return `html > ${selector.toLowerCase()}`;
        }
    </script>
    <script src="/js/formio.full.min.js"></script>

    <script>
        //constant
        const AUDIO = 'AUDIO';
        const VIDEO_TIMESTAMPS = 'VIDEO_TIMESTAMP';
        const IMAGE = 'IMAGE';
        const PDF = 'PDF';
        const VIDEO = 'VIDEO';
        const ASSET_BUNDLE = 'ASSET_BUNDLE';
        const DOCUMENT = 'DOCUMENT';
        const CLASSIN = 'CLASSIN';

        const typeFileSelect = [
            {"label": AUDIO, "value": AUDIO},
            {"label": VIDEO_TIMESTAMPS, "value": VIDEO_TIMESTAMPS},
            {"label": PDF, "value": PDF},
            {"label": IMAGE, "value": IMAGE},
            {"label": VIDEO, "value": VIDEO},
            {"label": ASSET_BUNDLE, "value": ASSET_BUNDLE},
            {"label": DOCUMENT, "value": DOCUMENT},
            {"label": CLASSIN, "value": CLASSIN},
        ]
    </script>
    @yield('third_party_stylesheets')

    @stack('page_css')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
</head>

<body>
<div class="wrapper" id="layout-wrapper">
    <div class="vertical-overlay"></div>
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="/images/EdupiaLogo.png"
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="/images/EdupiaLogo.png"
                             class="img-circle elevation-2"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper main-content">
        <section class="content">
            @yield('content')
            <x-file-selector></x-file-selector>
            <x-file-preview></x-file-preview>
            <x-custom-component></x-custom-component>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0.0
        </div>
        <strong>Copyright &copy; 2022 <a href="https://tracking2.edupia.vn/pages/viewpage.action?pageId=4538016"
                                         class="font-weight-bold" target="_blank">Product Solutions Team</a>.</strong>
        All rights
        reserved.
    </footer>
    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
</div>

<!-- JAVASCRIPT -->
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/sweetalerts.init.js')}}" aria-hidden="true">
    <script type="text/javascript" src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/js/pages/modal.init.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.js') }}"></script>
<script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>

<script type="javascript" src="/storage/js/render-form-attribute.js" defer></script>
<script type="javascript" src="/storage/js/form-helper.js" defer></script>
<script type="javascript" src="/storage/js/qs.js" defer></script>
<script type="javascript" src="/storage/js/file-helper.js" defer></script>

@stack('init_page_scripts')
@stack('page_scripts')
@stack('page_scripts_qa')
</body>
</html>
