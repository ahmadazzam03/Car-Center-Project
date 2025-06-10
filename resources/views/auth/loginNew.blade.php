<x-guest-layout title="Login Page">
    @session('error')
        {{session('error')}}
    @endsession

<main class="login-main">
        <div class="box">
        <div class="inner-box">
            <div class="login-forms-wrap">
            {{-- Login Form  --}}
            <form 
            action="{{route('login.store')}}"
            method="post" 
            class="sign-in-form">
            @csrf
                <div class="login-logo">
                    <img src="image/Logoorange.png" 
                    alt="..." height="100px"/>
                    <h4>Car Center</h4>
                </div>

                <div class="login-heading my-large">
                    <h2>Welcome Back</h2>
                    <h6>Not registred yet?</h6>
                    <a href="{{route('signup')}}" style="display: inline ;margin-left:5px" 
                    class="toggle">Sign up</a>
                </div>


                <div class="actual-form">
                <div class="input-wrap @error('email') has-error @enderror" >
                    <input type="email" class="input-field" 
                    name="email" value="{{old('email')}}"  />
                    <div class="error-message" >{{$errors->first('email')}}</div>
                    <label class="label" style="top:-4px" >Email</label>
                </div>
                

                <div class="input-wrap @error('password') has-error @enderror">
                    <input type="password" class="input-field" 
                    name="password" value="{{old('password')}}" />
                    <div class="error-message">{{$errors->first('password')}}</div>
                    <label class="label"  style="top:-2px" >Password</label>
                </div>

                <div class="text-right mb-medium">
                  <a href="{{route('password.request')}}" class="auth-page-password-reset">
                    Forgot Password?
                  </a>
                </div>

                <input type="submit" 
                value="Login" class="login-sign-button" />

                <p class="social-text">Or Login with social platforms as customer </p>
                <div class="social-media">
                  <a href="{{ route('login.oauth', 'facebook') }}" class="social-icon">
                    <i class='bx bxl-facebook'></i>
                </a>
                <a href="{{ route('login.oauth', 'google') }}" 
                class="social-icon">
                    <i class='bx bxl-google'></i>
                </a>
                </div>

              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="image/image1.png" class="image img-1 show" alt="" />
              <img src="image/image2.png" class="image img-2" alt="" />
              <img src="image/image3.png" class="image img-3" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                    <h2>Welcome to Car Center Website</h2>
                  <h2>Choose Your Dream Car</h2>
                  <h2>Buy The Best Cars in your region</h2>
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script>
      // login -sign up page 
const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");


function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});


/*-------------------------------------------------*/
document.addEventListener("DOMContentLoaded", () => {
    const bulletElements = Array.from(document.querySelectorAll(".bullets span"));
    const sliderImages = Array.from(document.querySelectorAll(".images-wrapper .image"));
    const textSlider = document.querySelector(".text-group");
  
    let currentIndex = 0;
  
    function updateSlider(index) {
      sliderImages.forEach((img, i) => {
        img.classList.toggle("show", i === index);
      });
  
      bulletElements.forEach((bullet, i) => {
        bullet.classList.toggle("active", i === index);
      });
  
      textSlider.style.transform = `translateY(-${index * 2.2}rem)`;
  
      currentIndex = index;
    }
  
    bulletElements.forEach((bullet, index) => {
      bullet.addEventListener("click", () => {
        updateSlider(index);
      });
    });
  
    setInterval(() => {
      let nextIndex = (currentIndex + 1) % sliderImages.length;
      updateSlider(nextIndex);
    }, 5000);
  });
    </script> 
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
</x-guest-layout>
