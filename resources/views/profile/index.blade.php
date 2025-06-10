<x-app-layout title="My Profile">
    <div class="main-profile" style="margin-top:80px">
    <div class="profile-container-first">
        <h2 class="h2-class-first">My Profile</h2>
        <div class="profile-content-first">
            <div class="sidebar-first-one">
                <button class="tab-first active" onclick="showTab('general')">General</button>
                <button class="tab-first" onclick="showTab('password')">Change Password</button>
            </div>

            <div class="main-content-first">
                <div id="general" class="tab-content-first active">
                    <div class="profile-header-first">
                        <div class="profile-pic-container-first">
                            <img id="profile-pic" 
                            src="{{$user->profile_image ? 
                            asset('storage/'.$user->profile_image) :  
                            asset('/img/avatar.png')}}" 
                            alt="Profile Picture">
                            <button class="upload-btn-first" onclick="document.getElementById('upload-input').click()">Upload new photo</button>
                        </div>
                    </div>
                    
                    <div class="profile-form-first">
                        <form 
                        action="{{route('profile.update')}}"
                        method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="@error('image') has-error @enderror">
                            <label >Profile Picture</label>    
                            <input type="file" id="upload-input" name="image"  accept="image/*" hidden>
                            <div class="text-error mb-small">{{ $errors->first('image') }}</div>
                        </div>

                        <div class="@error('name') has-error @enderror">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Your Name" 
                        value="{{old('name',$user->name)}}">
                        <p class="error-message">{{$errors->first('name')}}</p>
                        </div>

                        <div class="@error('email') has-error @enderror">
                            {{-- we disable changing email if the user is signed up with Google or Facebook --}}
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Your Email" 
                            value="{{old('email',$user->email)}}" 
                            @disabled($user->isOauthUser())>
                            <p class="error-message">{{$errors->first('email')}}</p>
                        </div>
                        
                        <div class="@error('phone') has-error @enderror">
                            <label>Phone Number</label>
                            <input type="text" name="phone" id="phone_number" placeholder="07XXXXXXXX" 
                            maxlength="10"
                            value="{{old('phone',$user->phone)}}">
                            <p class="error-message">{{$errors->first('phone')}}</p>
                        </div>
                        
                        <div class="buttons-first-btn-one">
                            <button type="submit" class="save-btn-first-one">Save Changes</button>
                            <button class="cancel-btn-first-one">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>

                <div id="password" class="tab-content-first">
                    <div class="profile-form-first">
                        <form 
                        action="{{route('profile.updatePassword')}}"
                        method="post">
                        @csrf
                        @method('PUT')
                    
                        <label>Current Password</label>
                        <div class="password-field-first @error('current_password') has-error @enderror">
                            <input type="password" id="current-password" 
                            name="current_password" 
                            placeholder="Current Password">
                            <span class="eye-icon" onclick="togglePassword('current-password')">👁️</span>
                            <p class="error-message">{{$errors->first('current_password')}}</p>
                        </div>

                        <label>New Password</label>
                        <div class="password-field-first @error('password') has-error @enderror">
                            <input type="password" id="new-password" name="password" placeholder="New Password">
                            <span class="eye-icon" onclick="togglePassword('new-password')">👁️</span>
                            <p class="error-message">{{$errors->first('password')}}</p>
                        </div>

                        <label>Confirm Password</label>
                        <div class="password-field-first">
                            <input type="password" id="confirm-password" 
                            name="password_confirmation" placeholder="Repeat Password">
                            <span class="eye-icon" onclick="togglePassword('confirm-password')">👁️</span>
                        </div>

                        <div class="buttons-first-btn-one">
                            <button type="submit" class="save-btn-first-one">Save Changes</button>
                            <button class="cancel-btn-first-one">Cancel</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   function showTab(tabId) {
  document.querySelectorAll('.tab-content-first').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab-first').forEach(button => button.classList.remove('active'));
  
  document.getElementById(tabId).classList.add('active');
  
  document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');

  localStorage.setItem('activeTab', tabId);
}

document.addEventListener('DOMContentLoaded', () => {
  const savedTab = localStorage.getItem('activeTab');
  if (savedTab) {
    showTab(savedTab);
  } else {
    showTab('defaultTabId');
  }
});

document.getElementById('upload-input').addEventListener('change', function(event) {
  const file = event.target.files[0];
  if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
          document.getElementById('profile-pic').src = e.target.result;
      };
      reader.readAsDataURL(file);
  }
});

function resetImage() {
  document.getElementById('profile-pic').src = "default-avatar.png";
}

function togglePassword(inputId) {
  const input = document.getElementById(inputId);
  if (input.type === "password") {
      input.type = "text";
  } else {
      input.type = "password";
  }
}
</script>
</x-app-layout>