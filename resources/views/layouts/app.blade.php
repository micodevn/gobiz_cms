<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>

    <meta charset="utf-8" />
    <title>@yield('title') GoBiz CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}" />
    <!-- App favicon -->
    <link rel="stylesheet" type="text/html" href="{{asset('')}}">
    <link rel="shortcut icon" href="{{asset('images/fv.png')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet">
    <link href="{{asset('/css/bootstrap4-toggle.min.css')}}" rel="stylesheet">
    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="/css/app.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{asset('/css/flatpickr.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/formio.full.min.js"></script>
    <style>
        #cover-spin {
            position:fixed;
            width:100%;
            left:0;right:0;top:0;bottom:0;
            background-color: rgba(255,255,255,0.7);
            z-index:9999;
            display:none;
        }

        @-webkit-keyframes spin {
            from {-webkit-transform:rotate(0deg);}
            to {-webkit-transform:rotate(360deg);}
        }

        @keyframes spin {
            from {transform:rotate(0deg);}
            to {transform:rotate(360deg);}
        }

        #cover-spin::after {
            content:'';
            display:block;
            position:absolute;
            left:48%;top:40%;
            width:40px;height:40px;
            border-style:solid;
            border-color:black;
            border-top-color:transparent;
            border-width: 4px;
            border-radius:50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>
</head>

<body>
<!-- Begin page -->
<div id="layout-wrapper">
    <x-file-selector></x-file-selector>
    <x-file-preview></x-file-preview>
    <x-custom-component></x-custom-component>
    @include('layouts.sidebar')
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
                @include('message')

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
    <!-- Loader -->
    <div id="cover-spin"></div>
</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js" defer></script>
<script>
    const uid = () => {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    };
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
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/sweetalerts.init.js')}}" aria-hidden="true"></script>
{{--<script src="{{asset('assets/js/plugins.js')}}"></script>--}}
<script type="text/javascript" src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/js/pages/modal.init.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('/js/bootstrap4-toggle.min.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.js') }}"></script>
<script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/js/axios.min.js') }}"></script>
<script src="{{ asset('storage/js/render-form-attribute.js') }}"></script>
<script src="{{ asset('storage/js/form-helper.js') }}"></script>
<script src="{{ asset('storage/js/qs.js') }}"></script>
<script src="{{ asset('storage/js/file-helper.js') }}"></script>
@stack('page_scripts')
</body>
</html>
