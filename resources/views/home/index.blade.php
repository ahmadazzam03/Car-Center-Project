<x-app-layout title="Home Page">
  <!--- Strat HERO Section-->
  <main>
    <article>
      <section class="section hero" id="home">
        <div class="container">
          <div class="hero-content">
            {{-- For Owner Role --}}
            @if (Auth::user()?->role?->name === 'owner')
            <h2 class="h1 hero-title"><strong>Do you want</strong> to sell your car?</h2>
            <p class="hero-text">
              Submit your car in our user friendly interface, describe it,<br>
              upload photos and the perfect buyer will find it...
            </p>
            {{-- For User Role --}}
            @elseif (Auth::user()?->role?->name === 'user' )
            <h2 class="h1 hero-title"><strong>Buy The Best Cars</strong> in your region .</h2>
            <p class="hero-text">
              Use powerful search tool to find your desired cars based on
              multiple <br> search criteria: Maker, Model, Year, Price Range, Car
              Type, etc...
            </p>
            {{-- For Guest Role --}}
            @else
            <h2 class="h1 hero-title"><strong>Discover</strong> the Best Cars in your region .</h2>
            <p class="hero-text">
              Use our powerful search tool to explore cars based on <br>
              Maker, Model, Year, Price Range, Car Type, and more.
            </p>
            @endif
          </div>

          <div class="hero-banner"></div>
          <form class="hero-form">
            <div class="input-wrapper">
              @guest
              <label for="input-1" class="input-label">Search a car , model , or price</label>
              @endguest
              @auth
              @if(Auth::user()?->role?->name === 'user' )
              <label for="input-1" class="input-label">Search a car , model , or price</label>
              @else
              <label for="input-1" class="input-label">Create your car ?</label>
              @endif
              @endauth
              <div class="cta">
                @guest
                <a href="{{route('car.search')}}" class="ptn access-btn">See Details</a>
                @endguest
                @auth
                @if(Auth::user()?->role?->name === 'user' )
                  <a href="{{route('car.search')}}" class="ptn access-btn">See Details</a>
                @else
                  <a href="{{route('car.create')}}" class="ptn access-btn">See Details</a>
                @endif
                @endauth
            </div>
            </div>
  
            <div class="input-wrapper">
              @guest
              <label for="input-2" class="input-label">Do you want to buy a car ?</label>
              @endguest
              @auth
              @if(Auth::user()?->role?->name === 'user' )
              <label for="input-2" class="input-label">Do you want to buy a car ?</label>
              @else
              <label for="input-2" class="input-label">Edit your car ?</label>
              @endif
              @endauth
                <div class="cta">
                  @guest
                  <a href="{{route('car.search')}}" class="ptn access-btn">See Details</a>
                  @endguest
                  @auth 
                  @if(Auth::user()?->role?->name === 'user' )
                  <a href="{{route('car.search')}}" class="ptn access-btn">See Details</a>
                  @else
                  <a href="{{route('car.index')}}" class="ptn access-btn">See Details</a>
                  @endif
                  @endauth
                </div>
            </div>

            <div class="input-wrapper">
              @guest
              <button type="button" ><a class="btn" href="{{route('signup')}}" >Get Started</a></button>
              @endguest
              @auth
              @if(Auth::user()?->role?->name === 'user' )
              <button type="button" ><a class="btn" href="#slideCar" >Get Started</a></button>
              @else
              <button type="button" ><a class="btn" href="{{route('car.create')}}" >Get Started</a></button>
              @endif
              @endauth
            </div>
          </form>
        </div>
      </section>
    </article>
  </main> 
  <!--- End HERO Section-->
<main>
  {{--  Start About Section  --}}
  <section class="section service has-bg-image my-large" 
    id="about" aria-labelledby="service-label">
    <div class="container">
      <p class="section-subtitle :light" id="service-label">About</p>
      <h2 class="section-subtitle-2 my-large " >We Provide Some Service For You</h2>
      <ul class="service-list my-large">
        <li>
          <div class="service-card my-large">
            <figure class="card-icon">
              <img src="image/car-sales.png" width="80" height="80" loading="lazy" alt="Engine Repair">
            </figure>
            <h3 class="h3 card-title">Car Sales</h3>
            <p class="card-text">
              Explore a wide range of vehicles available for sale, including electric cars, directly from verified sellers.
            </p>
          </div>
        </li>

        <li>
          <div class="service-card my-large">
            <figure class="card-icon">
              <img src="image/advanced-search.png" width="70" height="60" loading="lazy" alt="Brake Repair">
            </figure>
            <h3 class="h3 card-title">Advanced Search & Filtering</h3>
            <p class="card-text">
              Find your perfect car with our powerful search and filtering system, making it easy to refine your choices.          </p>
          </div>
        </li>

        <li>
          <div class="service-card my-large">
            <figure class="card-icon">
              <img src="image/services-3.png" width="80" height="60" loading="lazy" alt="Tire Repair">
            </figure>
            <h3 class="h3 card-title">Dealer Listings</h3>
            <p class="card-text">
              Car dealers can list their vehicles for sale, reaching a broad audience of potential buyers.
            </p>
          </div>
        </li>

        <li>
          <div class="service-card my-large">
            <figure class="card-icon">
              <img src="image/services-4.png" width="70" height="70" loading="lazy"
                alt="Battery Repair">
            </figure>
            <h3 class="h3 card-title">Charging Station points</h3>
            <p class="card-text">
              Use our integrated map system to find and navigate to nearby electric vehicle charging stations.
            </p>
          </div>
        </li>

        <li class="service-banner">
          <img src="image/BMD.png" width="646" height="380" loading="lazy" alt="Red Car"
            class="move-anim">
        </li>

        <li>
          <div class="service-card">
            <figure class="card-icon">
              <img src="image/services-6.png" width="70" height="60" loading="lazy"
                alt="Steering Repair">
            </figure>
            <h3 class="h3 card-title">Favorites List</h3>
            <p class="card-text">
              Save your favorite cars for easy access and comparison whenever you visit the site.
            </p>
          </div>
        </li>
      </ul>
    </div>
  </section>
  {{--  End About Section  --}}

  {{--Start Slider Car Section --}}
    <div class="sliderCar" id="slideCar">
    <section class="slider-section">
      <h2 class="title-15">Popular <span>Vehicles</span></h2>
      <div class="slider-container">
          <div class="slider">
            {{-- Car 1  --}}
              <div class="slide">
                  <img src="image/imagecar.jpg" loading="lazy"  alt="Car 1">
                  <div class="details">
                      <h3>Audi - E-torn</h3>
                      <p class="price">62,000 JOD</p>
                      <p>New • 2024 • Automatic • Electric • 183mph</p>
                  </div>
              </div>

            {{-- Car 2  --}}
              <div class="slide">
                  <img src="image/imagecar2.jpg" loading="lazy" alt="Car 1">
                  <div class="details">
                      <h3>BMW - i_3</h3>
                      <p class="price">70,000 JOD</p>
                      <p>New • 2022 • Automatic • Hybrid • 200mph</p>
                  </div>
              </div>

            {{-- Car 3  --}}
              <div class="slide">
                  <img src="image/imagecar3.jpg" loading="lazy" alt="Car 1">
                  <div class="details">
                      <h3>Chevrolate - Silverado</h3>
                      <p class="price">82,000 JOD</p>
                      <p>New • 2021 • Manual • Diesel • 500mph</p>
                  </div>
              </div>

            {{-- Car 4 --}}
              <div class="slide">
                  <img src="image/imagecar4.jpg" loading="lazy" alt="Car 1">
                  <div class="details">
                      <h3>Honda - Accord</h3>
                      <p class="price">30,000 JOD</p>
                      <p>New • 2020 • Automatic • Gasoline • 150mph</p>
                  </div>
              </div>

              {{-- Car 5 --}}
              <div class="slide">
                <img src="image/imagecar5.jpg" loading="lazy" alt="Car 1">
                <div class="details">
                    <h3>Tesla - Model_3</h3>
                    <p class="price">35,000 JOD</p>
                    <p>New • 2023 • Automatic • Electric • 132mph</p>
                </div>
              </div>

              {{-- Car 6 --}}
              <div class="slide">
                <img src="image/imagecar6.jpg" loading="lazy" alt="Car 1">
                <div class="details">
                    <h3>Nissan - Altima</h3>
                    <p class="price">50,000 JOD</p>
                    <p>New • 2024 • Automatic • Gasoline • 230mph</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="dots-container">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
          </div>
          
          @auth
          @if (Auth::user()->role->name === 'user')
          <a href="{{route('car.search')}}">
            <button class="checkout-btn">See More</button>
          </a>
          @endif
          @endauth
  </section>
    </div>
  {{--End Slider Car Section --}}


  {{-- Start  Our Team Section  --}}
    <div class="ourTeamSection" id="ourTeam">
    <section class="team-section">
      <h2>Meet Our Professional Team</h2>
      <div class="team-container">
          
          <div class="team-member">
              <div class="glass-effect">
                  <img src="image/jamelAlshalabe.png" style="height:300px"  loading="lazy" alt="Team Member">
                  <h3 class="header-name-h3">Jamel Alshalabe</h3>
                  <p class="header-name-p">Full Stack Developer</p>
                  <div class="social-icons">
                      <a ><i class="fa-brands fa-facebook"></i></a>
                      <a ><i class="fa-brands fa-twitter"></i></a>
                      <a ><i class="fa-brands fa-linkedin"></i></a>
                  </div>
              </div>
          </div>

          <div class="team-member">
              <div class="glass-effect">
                  <img src="image/abood.png" style="height:300px" loading="lazy" alt="Team Member">
                  <h3>Abdalrahman-Barri</h3>
                  <p>Front-End Developer</p>
                  <div class="social-icons">
                      <a ><i class="fa-brands fa-facebook"></i></a>
                      <a ><i class="fa-brands fa-twitter"></i></a>
                      <a ><i class="fa-brands fa-linkedin"></i></a>
                  </div>
              </div>
          </div>

          <div class="team-member">
              <div class="glass-effect">
                  <img src="image/ahmad.png" style="height:300px" loading="lazy" alt="Team Member">
                  <h3>Ahmad Azzam</h3>
                  <p>Front-End Developer</p>
                  <div class="social-icons">
                      <a ><i class="fa-brands fa-facebook"></i></a>
                      <a ><i class="fa-brands fa-twitter"></i></a>
                      <a ><i class="fa-brands fa-linkedin"></i></a>
                  </div>
              </div>
          </div>
      </div>
  </section>
    </div>
  {{-- End  Our Team Section  --}}
  
  {{-- Start Contact Section  --}}
  <section class="contact-form" id="contact">
    <h4 class="sectionHeader">Contact Us</h4>
    <h1 class="contact-heading">Get In Touch!</h1>
    <div class="contactForm">
        <form action="{{route('contact.ContactStore')}}" method="post" >
          @csrf
         <h1 class="sub-heading">Need Support !</h1>
         <p class="para para2">Contact us for a quote , help to join the them.</p>
         <input type="text" name="name" required  class="input contact-input" placeholder="your name">
         <input type="email" name="email" required  class="input contact-input" placeholder="your email">
         <input type="text" name="subject" required  class="input contact-input" placeholder="your Subject">
         <textarea class="input contact-input" required  name="message" style="resize:none;color:white;font-size:1rem" cols="30" rows="8" placeholder="Your message..."></textarea>
         <input type="submit" class="input submit contact-button" value="Send Message">
        </form>

        <div class="map-container">
            <div class="mapBg"></div>
            <div class="map">
                <iframe data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3383.6821402310493!2d35.80065897484883!3d31.996631123459114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca2465889dcfb%3A0xd32de476c8e39038!2sAmman%20St.!5e0!3m2!1sen!2sjo!4v1740222925666!5m2!1sen!2sjo" 
                width="600" height="450" style="border:0;" 
                allowfullscreen="" loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <div class="contactMethod">
        <div class="method">
            <i class="fa-solid fa-location-dot contactIcon"></i>
            <article class="text">
                <h1 class="contact-sub-heading">Location</h1>
                <p class="para">Amman-Jordan-Jordan Street</p>
            </article>
        </div>

        <div class="method">
            <i class="fa-solid fa-envelope contactIcon"></i>
            <article class="text">
                <h1 class="contact-sub-heading">Email</h1>
                <p class="para">Email: Car_Center@gmail.com</p>
            </article>
        </div>

        <div class="method">
            <i class="fa-solid fa-phone contactIcon"></i>
            <article class="text">
                <h1 class="contact-sub-heading">Phone</h1>
                <p class="para">Phone-Number :07#####</p>
            </article>
        </div>
    </div>
  </section>
  {{-- End Contact Section  --}}
</main>

</x-app-layout>

