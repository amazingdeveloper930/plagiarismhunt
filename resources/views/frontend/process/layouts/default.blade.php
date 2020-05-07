<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="descrition" content="Plagiarism multi checker. Check your paper for plagiarism with many scanners in one click. Compare results of different software and choose the best antiplagiarism tool">

	<link rel="icon" href="images/favicon.ico" type="image/ico" />

  <title>Plagiarism multi checker. Many scanners in one web</title>

    @include('panel_layout.style')


    <!-- jQuery -->
    <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107521779-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-107521779-6');
</script>

  </head>

  <body class="nav-sm">
   
  <input hidden value = "{{url('/')}}" id = "base_url"/>

    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('home')}}" class="site_title"><i class="fa fa-paw"></i> <span>Plagiarismhunt</span></a>
            </div>

            <div class="clearfix"></div>
            @include('frontend.process.layouts.sidebar')
          </div>
        </div>

        <!-- top navigation -->
        @include('frontend.process.layouts.top_nav')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
                
            @yield('content')

        </div>
        <!-- /page content -->
        @include('panel_layout.footer')

      </div>
    </div>

    @include('panel_layout.script')

    
    
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
