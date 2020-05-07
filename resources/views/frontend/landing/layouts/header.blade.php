<header>
        <div class="custom-header">
          <div class="container">
            <div class="row">
              <nav class="navbar navbar-expand-lg"> 
                  <a class="navbar-brand" href="#"><img src="{{ asset('landing/images/logo_transparent.png')}}" class="img-fluid" alt=""></a>
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"> <a class="nav-link" href="{{ route('home') }}">Home</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('home') . '#about-section' }}">About</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('home') . '#features-section' }}">Features</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('home') . '#contact-section' }}">Contact</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('plag_checkprice') }}">Plagiarism Checking Price</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('faq') }}">FAQs</a> </li>
                    
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </header>
      <button onclick="topFunction()" id="to-top" title="Go to top"><i class="fa fa-chevron-up"></i></button>