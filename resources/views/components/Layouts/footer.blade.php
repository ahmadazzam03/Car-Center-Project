<footer class="footer" id="footer">
    <div class="footer-container">
        <div class="row">
            <div class="footer-col">
                <h4>Car Center</h4>
                <ul>
                    @if(request()->routeIs('home'))
                    <li><a href="#home">home</a></li>
                    <li><a href="#about">about</a></li>
                    <li><a href="#ourTeam">our services</a></li>
                    <li><a href="#contact">contact us</a></li>
                    @else
                    <li><a >home</a></li>
                    <li><a >about</a></li>
                    <li><a >our services</a></li>
                    <li><a>contact us</a></li>
                    @endif
                </ul>
            </div>
            @auth
            @if (Auth::user()?->role?->name === 'user' )
            <div class="footer-col">
                <h4>get help</h4>
                <ul>
                    <li><a href="{{route('car.search')}}">Buy Car</a></li>
                    <li><a href="{{route('car.search')}}">Car Search</a></li>
                    <li><a href="{{route('wishList.index')}}">My favourite Cars</a></li>
                    <li><a href="{{route('home.chargingStations')}}" class="navbar-link"> Charging Station </a></li>
                    <li><a href="{{route('car.order')}}">My Order</a></li>
                </ul>
            </div>
            @elseif(Auth::user()?->role?->name === 'owner' )
            <div class="footer-col">
                <h4>get help</h4>
                <ul>
                    <li><a href="{{route('car.create')}}">Add Car</a></li>
                    <li><a href="{{route('car.index')}}">Edit car</a></li>
                    <li><a href="{{route('car.index')}}">Delete Car</a></li>
                    <li><a href="{{route('car.index')}}">Edit Car Image</a></li>
                    <li><a href="{{route('car.sales')}}">My Sales</a></li>
                </ul>
            </div>
            @endif
            @endauth
            @guest
            <div class="footer-col">
                <h4>Sign Up To get help</h4>
                <ul>
                    <li><a >Buy Car</a></li>
                    <li><a >Sale Car</a></li>
                    <li><a >Car Search</a></li>
                    <li><a >Add Car</a></li>
                    <li><a >Edit Car</a></li>
                    <li><a >Edit Car Image</a></li>
                    <li><a >My favourite Cars</a></li>
                </ul>
            </div>
            @endguest

            <div class="footer-col">
                <h4>follow us</h4>
                <div class="social-links" >
                    <a ><i class="fab fa-facebook-f"></i></a>
                    <a ><i class="fab fa-twitter"></i></a>
                    <a ><i class="fab fa-instagram"></i></a>
                    <a ><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>