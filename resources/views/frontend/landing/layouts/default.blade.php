<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="descrition" content="Plagiarism multi checker. Check your paper for plagiarism with many scanners in one click. Compare results of different software and choose the best antiplagiarism tool">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('landing/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('landing/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<title>Plagiarism multi checker. Many scanners in one web</title>
</head>
<script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('js/landingtheme/sweetalert2.js') }}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107521779-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-107521779-6');
</script>


<body>
<input hidden value = "{{url('/')}}" id = "base_url"/>
@include('frontend.landing.layouts.header')

@yield('content')

@include('frontend.landing.layouts.footer')

<!-- Optional JavaScript --> 
<!-- jQuery first, then Popper.js, then Bootstrap JS --> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
<script src="{{ asset('landing/js/owl.carousel.min.js') }}"></script> 
<script src="{{ asset('landing/js/custom.js') }}"></script>

<script type="text/javascript">
    adroll_adv_id = "IIKIH3KTLNCWBASEY52UDA";
    adroll_pix_id = "5ETNZEBQUZA4FCVKOIDPTZ";

    (function () {
        var _onload = function(){
            if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}
            if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}
            var scr = document.createElement("script");
            var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
            scr.setAttribute('async', 'true');
            scr.type = "text/javascript";
            scr.src = host + "/j/roundtrip.js";
            ((document.getElementsByTagName('head') || [null])[0] ||
                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
        };
        if (window.addEventListener) {window.addEventListener('load', _onload, false);}
        else {window.attachEvent('onload', _onload)}
    }());
</script>


</body>
</html>