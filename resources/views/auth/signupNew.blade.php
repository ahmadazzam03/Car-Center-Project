<x-guest-layout title="SignUp Page">
<main class="login-main">
        <div class="box">
        <div class="inner-box">
            <div class="login-forms-wrap">
            <form 
            action="{{route('signup.store')}}" 
            method="post" 
            class="sign-in-form">
            @csrf

              <div class="login-heading my-large">
                <h6>Already have an account?
                  <a href="{{route('login')}}" style="display: inline ;margin-left:5px " class="toggle">Login</a>
                </h6>
                
              </div>

              <div class="actual-form">
                <div class="input-wrap @error('name') has-error @enderror">
                  <input type="text" class="input-field"  name="name" 
                    value="{{old('name')}}" />
                    <div class="error-message">{{$errors->first('name')}}</div>
                  <label class="label">Name</label>
                </div>

                <div class="input-wrap @error('email') has-error @enderror">
                  <input type="email" name="email" class="input-field"
                    value="{{old('email')}}"/>
                    <div class="error-message" >{{$errors->first('email')}}</div>
                  <label class="label">Your Email</label>
                </div>

                <div class="input-wrap @error('phone') has-error @enderror">
                  <input type="text" class="input-field"  maxlength="10" name="phone" 
                  value="{{old( 'phone')}}" />
                  <div class="error-message" >{{$errors->first('phone')}}</div>
                  <label class="label">Phone</label>
                </div>

                <div class="input-wrap @error('password') has-error @enderror">
                  <input type="text" class="input-field" name="password"  />
                  <div class="error-message">{{$errors->first('password')}}</div>
                  <label class="label">Your Password</label>
                </div>

                <div class="input-wrap">
                  <input type="password" class="input-field"  name="password_confirmation" />
                  <label class="label">Repeat Password</label>
                </div>
                <div class="form-group @error('role_id') has-error @enderror" >
                  <div class="radio-buttons-container">
                    <div class="radio-button">
                      <input name="role_id" value="user" 
                      id="radio2" class="radio-button__input" type="radio">
                      <label for="radio2" class="radio-button__label">
                        <span class="radio-button__custom"></span>
                            User
                      </label>
                    </div>
                    <div class="radio-button">
                      <input name="role_id" value="owner" 
                      id="radio1" class="radio-button__input" type="radio">
                      <label for="radio1" class="radio-button__label">
                        <span class="radio-button__custom"></span>
                        Owner
                      </label>
                    </div>
                    </div>
                <div class="error-message">{{$errors->first('role_id')}}</div>
              </div>

                <input type="submit" value="Sign Up" class="login-sign-button" />

                <p class="social-text">Or Login with social platforms as customer</p>
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
