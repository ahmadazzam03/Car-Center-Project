<header class="header" data-header >
  <div class="container">
    <div class="overlay" data-overlay></div>
    {{-- Logo For Website  --}}
    <a href="{{route('home')}}" class="logo">
      <img src="/image/Logoorange.png" 
      alt="Ridex logo"  loading="lazy"
      width="100" height="100" style="margin-top: 10px;">
    </a>

    <nav class="navbar" data-navbar>
      <ul class="navbar-list">
        <li>
          <a href="/" class="navbar-link" data-nav-link><i class="fa-solid fa-house"></i> Home</a>
        </li>
        @if(request()->routeIs('home'))
        <li>
          <a href="#about" class="navbar-link" data-nav-link>About</a>
        </li>
        <li>
          <a href="#ourTeam" class="navbar-link" data-nav-link>Our Team</a>
        </li>
        <li>
          <a href="#contact" class="navbar-link" data-nav-link>Contact</a>
        </li>
        @auth
        @if(Auth::user()->role->name ===  'owner' )
        <li><a href="{{route('car.create')}}" class="btn btn-add-new-car">
          <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          style="width: 19px; margin-right: 6px">
          <path
          stroke-linecap="round"
          stroke-linejoin="round"
              d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          </svg>
          Add New Car
        </a>
        </li>
        @endif
        @endauth
        @endif

        @auth


        {{-- For Car Service --}}
        @if(Auth::user()?->role?->name === 'user' )
        <div class="navbar-menu" tabindex="-1">
          <a href="javascript:void(0)" class="navbar-link">
            <i class="fa-solid fa-car"></i> Customer Service
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              style="width: 12px">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>
          </a>
          <ul class="submenu">
            <li><a href="{{route('car.search')}}" class="navbar-link"> Show Cars <i class="fa-solid fa-car" style="float: right"></i></a></li>
            <li><a href="{{route('car.search')}}" class="navbar-link"> Car Search <i class="fa-solid fa-magnifying-glass" style="float: right"></i></a></li>
            <li><a href="{{route('home.chargingStations')}}" class="navbar-link"> Charging Station <i class="fa-solid fa-charging-station" style="float: right"></i></a></li>
            <li><a href="{{route('wishList.index')}}" class="navbar-link">My Favourite Cars <i class="fa-solid fa-heart" style="float: right"></i></a></li>
          </ul>
        </div>

        @elseif(Auth::user()?->role?->name === 'owner')
        <div class="navbar-menu" tabindex="-1">
          <a href="javascript:void(0)" class="navbar-link">
            <i class="fa-solid fa-user"></i> Owner Service
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              style="width: 12px">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>
          </a>
          <ul class="submenu">
            <li><a href="{{route('car.index')}}" class="navbar-link">My Cars <i class="fa-solid fa-car"  style="float: right"></i></a></li>
            <li><a href="{{route('car.create')}}" class="navbar-link">Car Create <i class="fa-solid fa-plus" style="float: right"></i></a></li>
            <li><a href="{{route('home.chargingStations')}}" class="navbar-link"> Charging Station <i class="fa-solid fa-charging-station" style="float: right"></i></a></li>
          </ul>
        </div>
        @endif
        {{-- Settings && Logout --}}
        <div class="navbar-menu" tabindex="-1">
        <a href="javascript:void(0)" class="navbar-link">
          <i class="fa-solid fa-gear"></i> {{Auth::user()->name}}
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            style="width: 12px">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
          </svg>
        </a>
        <ul class="submenu">
          <li><a href="{{route('profile.index')}}" class="navbar-link">Account Setting <i class="fa-solid fa-user" style="float: right"></i></a></li>
          @if(Auth::user()->role->name === 'owner' )
          <li><a href="{{route('owner.purchase-requests.pending')}}" class="navbar-link">Purchase Requests <i class="fa-solid fa-code-pull-request" style="float: right"></i></a></li>          
          <li><a href="{{route('car.sales')}}" class="navbar-link">My Sales <i class="fa-solid fa-cart-arrow-down" style="float: right"></i></a></li>          
          @else
          <li><a href="{{route('purchase_requests.myRequests')}}" class="navbar-link">Purchase Requests <i class="fa-solid fa-code-pull-request" style="float: right"></i></a></li>          

          <li><a href="{{route('car.order')}}" class="navbar-link">My Orders <i class="fa-solid fa-cart-shopping" style="float: right"></i></a></li>
          @endif
          {{-- Logout --}}
          <li>
            <form 
            action="{{route('logout')}}" 
            method="post" >
              @csrf
              <button class="navbar-link" style="">Logout <i class="fa-solid fa-arrow-right-from-bracket" style="float: right" ></i></button>
            </form>
          </li>
        </ul>
        </div>
      @endauth

      
      </ul>
    </nav>

    <div class="header-actions">
      @guest     
      <a href="{{route('signup')}}" class="btn" aria-labelledby="aria-label-txt">
          <ion-icon name="add-circle-outline"></ion-icon>
          <span id="aria-label-txt">Signup</span>
      </a>

      <a href="{{route('login')}}" class="btn user-btn" aria-label="Profile" style="color: #fff;">
        {{-- <span id="aria-label-txt">Login</span> --}}
          <ion-icon name="log-out-outline"></ion-icon>
      </a>
      @endguest

      @if(request()->routeIs('home'))
      {{-- Dark / Light Mode Button  --}}
      <div class="toggle-btn" id="toggle-theme">
          <i class='bx bx-moon'></i>
      </div>
      @endif
      {{-- This button For mobile Toggle menu --}}
      <button class="nav-toggle-btn" data-nav-toggle-btn aria-label="Toggle Menu">
        <span class="one"></span>
        <span class="two"></span>
        <span class="three"></span>
      </button>

    </div>
    
  </div>
</header>
  <script src="https://unpkg.com/scrollreveal"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

