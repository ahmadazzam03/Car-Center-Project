<x-admin-app title="Dashboard Page" >
<!-- MAIN CONTAINER  -->
<div class="main-container">
    <!-- TITLE  -->
    <div class="title">
      <p>
        <a href="{{route('admin.dashboard')}}"><span>Dashboard</span></a>
        <i class="bx bx-right-arrow-alt"></i>
        Car Center
      </p>
      <h3>Car Center Dashboard</h3>
    </div>

    <!-- CARDS  -->
    <div class="cards">
      <!-- CARD 1 -->
      <div class="card card-1">
        <div class="card-text">
          <span>Total Owner</span>
          <h4 style="background: transparent;">{{$ownersCount}}</h4>
        </div>
        <div class="card-icon">
          <span><i class='bx bxs-user'></i></span>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="card card-2">
        <div class="card-text">
          <span>Total Users</span>
          <h4 style="background: transparent;">{{$usersCount}}</h4>
        </div>
        <div class="card-icon">
          <span><i class="bx bx-group"></i></span>
        </div>
      </div>
      <!-- CARD 3 -->
      <div class="card card-3">
        <div class="card-text">
          <span>Total Cars</span>
          <h4 style="background: transparent;">{{$carsCount}}</h4>
          
        </div>
        <div class="card-icon">
          <span><i class="fa fa-car" style="font-size:20px;"></i></span>
        </div>
      </div>
      <!-- CARD 4 -->
      <div class="card card-4">
        <div class="card-text">
          <span>Total Order</span>
          <h4 style="background: transparent;">{{$ordersCount}}</h4>
        </div>
        <div class="card-icon">
          <span><i class="bx bx-cart-alt"></i></span>
        </div>
      </div>
    </div>
    <!-------------------- CHARTS ---------------------->
    <div class="charts">
      <!-- CHART 1 -->
      <div class="chart">
        <div class="chart-top">
          <h4>Cars Center Chart</h4>
          <select>
            <option selected>Sort By</option>
            <option>This Week</option>
            <option>Last Week</option>
            <option>This Month</option>
          </select>
        </div>
        <div class="chart-bottom">
          <canvas id="barChart" height="100%" width="100%"></canvas>
        </div>
      </div>
      <!-- CHART 2 -->
      <div class="chart">
        <div class="chart-top">
          <h4>Order Statistics</h4>
          <span> <i class="bx bx-dots-vertical-rounded"></i></span>
        </div>
        <div class="chart-bottom">
          <canvas id="douChart" height="100%" width="100%"></canvas>
        </div>
      </div>
    </div>
  </div>
  <!-- BACKDROP FILTER  -->
  <div class="backdrop-filter"></div>

</x-admin-app>