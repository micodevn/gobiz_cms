<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    Edupia Primary
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Edupia Primary CMS" name="description" />
    <meta name="description" content="Edupia - Học Tiếng Anh online như ở Trường Quốc tế">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="Edupia Secondary">
    <meta itemprop="description" content="Edupia - Học Tiếng Anh online như ở Trường Quốc tế">
    <meta itemprop="image" content="https://static.edupia.vn/images/logo-c2.png">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://cmslab2.edupiasecondary.vn/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Edupia Secondary">
    <meta property="og:description" content="Edupia - Học Tiếng Anh online như ở Trường Quốc tế">
    <meta property="og:image" content="https://static.edupia.vn/images/logo-c2.png">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Edupia Secondary">
    <meta name="twitter:description" content="Edupia - Học Tiếng Anh online như ở Trường Quốc tế">
    <meta name="twitter:image" content="https://static.edupia.vn/images/logo-c2.png">
    <meta name="author" content="Dev Edupia">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="#" class="d-inline-block auth-logo">
                                <h3 class="text-white mb-1">Edupia Primary</h3>
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium"></p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Edupia Primary.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form id="formLogin" action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" value="{{ old('username') }}" name="username" placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5" name="password" placeholder="Enter password" id="password-input" value="{{ old('password') }}">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="remember_me" id="auth-remember-check" checked>
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Sign In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    {{--                    <div class="mt-4 text-center">--}}
                    {{--                        <p class="mb-0">Don't have an account ? <a href="#" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>--}}
                    {{--                    </div>--}}

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>

</body>

</html>
