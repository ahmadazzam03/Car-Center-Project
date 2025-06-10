<x-guest-layout title="Forgot Password">
    <div class="form-container">
        <div class="logo-container">
            Request Password Reset
        </div>
        <form 
        action="{{route('password.email')}}" 
        method="post"
        class="form">
        @csrf
            <div class="form-group @error('email') has-error @enderror">
                <label for="email">Email</label>
                <input type="email" 
                placeholder="Your Email" 
                name="email" 
                value="{{old('email')}}"
                id="email">
                <div class="error-message">{{$errors->first('email')}}</div>
            </div>
            <button class="btn btn-primary btn-login w-full" type="submit">Request password reset</button>
        </form>
        <div class="login-text-dont-have-account">
            Already have an account? -
            <a href="{{route('login')}}"> Click here to login </a>
        </div>
    </div>
    
</x-guest-layout>
