<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Appai - Home 1</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" href="favicon.ico">
    <!-- all additional css -->
    <link rel="stylesheet" href="{{ asset('css/landingtheme/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landingtheme/elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landingtheme/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landingtheme/responsive.css') }}">
    <!-- modernizr js -->
    <script src="{{ asset('js/landingtheme/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- prelaoder start -->
    <div id="preloader-wrapper">
        <div class="preloader-wave-effect"></div>
    </div>
    <!-- prelaoder end -->
    <!-- page wrapper start -->
  
    <div class="comming-soon-wrapper">
        <div class="ovarlay"></div>
        <header>
            <div class="container">
                <div class="logo">
                    <a href="#"><img src="img/logo/logo-3.png" alt="" class="img-responsive"></a>
                </div>
            </div>
        </header>
    </div>
    <!-- page wrapper end -->

    @include('frontend.landing.layouts.script')  
</body>

</html>
