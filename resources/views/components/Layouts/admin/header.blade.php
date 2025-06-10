<!-- HEADER  -->
<div class="header">
    <!-- LOGO  -->
    <div class="logo" style="background-color: white">
      <img src="/image/Logoorange.png" 
      class="lg-logo" loading="lazy"
      width="100" height="100" style="margin-top: 10px;" />
      <img src="" class="sm-logo"/>
    </div>

    <!-- SEARCH INPUT  -->
    <div class="search-input">
      <button class="toggle-menu">
        <i class="bx bx-menu"></i>
      </button>


      <div class="InputContainer">
        <input type="text" name="text" class="input" id="input" placeholder="Search">
      
        <label for="input" class="labelforsearch">
      <svg viewBox="0 0 512 512" class="searchIcon">
        <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
      </label>
      <div class="border"></div>
      
      <button class="micButton"><svg viewBox="0 0 384 512" class="micIcon"><path d="M192 0C139 0 96 43 96 96V256c0 53 43 96 96 96s96-43 96-96V96c0-53-43-96-96-96zM64 216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 89.1 66.2 162.7 152 174.4V464H120c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H216V430.4c85.8-11.7 152-85.3 152-174.4V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 70.7-57.3 128-128 128s-128-57.3-128-128V216z"></path></svg>
      </button>
      </div>
    </div>

    <!-- SMART ICONS  -->
    <div class="smart-icons">
      <div class="profile">
        <div class="profile-content">
          <img 
          style=" width: 40px;
          height: 40px;
          border-radius: 40px;"
          id="profileImg" src="{{Auth::user()->profile_image ? 
          asset('storage/'.Auth::user()->profile_image) :  
          asset('/img/avatar.png')}}">
          
          <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          style="width: 15px">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
        </svg>
          <div class="dropdown-menu" id="dropdownMenu">
            <ul>
                  <li>
                    <a href="{{route('admin.adminProfile')}}" class="admin-a">
                      <i class='bx bx-user' style="float: right">
                        </i>Admin Profile
                      </a>
                    </li>
                  <li>
                    <form 
                    action="{{route('logout')}}" 
                    method="post">
                    @csrf
                    <button
                    style="background-color:#24262b;
                        padding: 6px;
                        align-items: center;
                        cursor: pointer;
                        transition: 0.3s;
                        color: red;"
                    class="admin-a">
                      
                      Logout
                    </button>
                    </form>
                  </li>
              </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- End Header --}}

  <!-- SIDEBAR  -->
  <div class="sidebar">
    <div class="align-element">
      <ul>
        <li class="active">
          <span><i class="bx bx-home"></i></span>
          <span><a href="{{route('admin.dashboard')}}">Dashboard</a></span>
        </li>
        
        <li>
          <span><i class="bx bx-group"></i></span>
          <span><a href="{{route('admin.showUserManagement')}}">User Managment</a></span>
        </li>

        <li>
          <span><i class='bx bxs-user'></i></span>
          <span><a href="{{route('admin.showOwnerManagement')}}">Owner Managment</a></span>
        </li>
        <li>
          <span><i class="fa fa-car" style="font-size:16px;"></i></span>
          <span><a href="{{route('admin.showCarManagement')}}">Car Managment</a></span>
        </li>
        <li>
          <span><i class="bx bx-cart-alt"></i></span>
          <span><a href="{{route('admin.showOrders')}}">Orders</a></span>
        </li>
        <li>
          <span><i class='bx bx-git-pull-request'></i></span>
          <span><a href="{{route('admin.showRequest')}}">Manage Request</a></span>
        </li>
        <li>
          <span><i class='bx bxs-inbox'></i></span>
          <span><a href="{{route('admin.inbox')}}">Inbox</a></span>
        </li>
      </ul>
    </div>
  </div>