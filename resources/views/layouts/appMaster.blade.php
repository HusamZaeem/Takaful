<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>@yield('title')</title>

    
    @include('layouts.stylesheets')
    
  </head>

<body>

  

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        Takaful
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                        <li class="scroll-to-section"><a href="#service">Services</a></li>
                        <li class="scroll-to-section"><a href="#apply">Submit or Support</a></li>
                        <li class="scroll-to-section"><a href="#hopeDelivered">Hope Delivered</a></li>
                        <li class="scroll-to-section"><a href="#contact">Contact Us</a></li>
                      
                        @auth
                          <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        @else
                          <li><a href="{{ route('login') }}">Log in</a></li>
                          @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Register</a></li>
                          @endif
                        @endauth
                      </ul>
                       
                
                    
                
                    
                    <a class='menu-trigger'><span>Menu</span></a>
                </nav>
                
              </div>
          </div>
      </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
      <video autoplay muted loop id="bg-video">
          <source src="{{ asset('images/freeGaza.mp4') }}" type="video/mp4" />
      </video>

      <div class="video-overlay header-text">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="caption">
              <h2>Welcome to Takaful</h2>
              <p>In response to the ongoing war and humanitarian crisis in Gaza, this platform has been built to connect those in need with those willing to help. Through transparent donation tracking, organized aid requests, and a secure case management system, we strive to bring critical support to families, children, and communities affected by the conflict. Every action taken here is a step toward relief, dignity, and hope for the people of Gaza.</p>
              <div class="main-button-red">
                  <div class="scroll-to-section"><a href="#contact">Contact Us</a></div>
              </div>
          </div>
              </div>
            </div>
          </div>
      </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->



    <!-- ***** Content Area Start ***** -->
  @yield('content')

  

  


  
  @include('layouts.scripts')

</body>

</body>
</html>