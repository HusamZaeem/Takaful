<header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="{{ route('home') }}" class="logo">Takaful</a>
            <ul class="nav">
              <li><a href="{{ url('/#top') }}">Home</a></li>
              <li><a href="{{ url('/#service') }}">Services</a></li>
              <li><a href="{{ url('/#apply') }}">Submit or Support</a></li>
              <li class="has-sub">
                <a href="#">Pages</a>
                <ul class="sub-menu">
                  <li><a href="{{ route('donations.create') }}">Make A Donation</a></li>
                  <li><a href="#">Register A Case</a></li>
                </ul>
              </li>
              <li><a href="{{ url('/#hopeDelivered') }}">Hope Delivered</a></li>
              <li><a href="{{ url('/#contact') }}">Contact Us</a></li>
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
  