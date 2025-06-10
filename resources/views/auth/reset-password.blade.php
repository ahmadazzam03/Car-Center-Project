<x-guest-layout title="Reset Password">
    <div class="form-container">
        <div class="logo-container">
            Reset Password
        </div>
        <form 
        action="{{route('password.update')}}" 
        method="post"
        class="form">
        @csrf
        <input type="hidden" name="token" value="{{request('token')}}">
        {{-- Just to display email for readonly  --}}

            <div class="form-group @error('email') has-error @enderror">
                <label for="email">Email</label>
                <input type="email" 
                readonly
                name="email" 
                value="{{ request('email') }}"
                id="email">
                <div class="error-message">{{$errors->first('email')}}</div>
            </div>

            <div class="form-group @error('password') has-error @enderror">
                <input type="password" placeholder="New Password" name="password"  />
                <div class="error-message">{{$errors->first('password')}}</div>
            </div>
    
            <div class="form-group">
                <input type="password" placeholder="Repeat New Password" name="password_confirmation"  />
            </div>
            <button class="btn btn-primary btn-login w-full" type="submit">Request password reset</button>
        </form>
    </div>

</x-guest-layout>
