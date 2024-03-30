<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-white" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    </div>
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li  class="nav-item">
          <a class="" href="{{route('homepage')}}">
            <img src="{{asset('/img/logo_.png')}}" class="" alt="main_logo" style="height: 130px;display: block;margin: auto;">
          </a>
          <p class="ms-1 font-weight-bold text-dark text-center mt-2">@auth {{ ucfirst(Auth::user()->role)}} @endauth Dashboard</p>
          <hr class="horizontal light mt-0 mb-2">
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link  {{request()->route()->getName() == 'dashboard.main' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('dashboard.main')}}">
            <div class="text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
          <a class="nav-link  {{request()->route()->getName() == 'dashboard.user-management.main' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('dashboard.user-management.main')}}">
            <div class="text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        @endif
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
        <li class="nav-item">
          <a class="nav-link  {{request()->route()->getName() == 'dashboard.services.main' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('dashboard.services.main')}}">
            <div class="text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">login</i>
            </div>
            <span class="nav-link-text ms-1">Services</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link  {{request()->route()->getName() == 'dashboard.token.main' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('dashboard.token.main')}}">
            <div class="text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dataset</i>
            </div>
            <span class="nav-link-text ms-1">Tokens</span>
          </a>
        </li>

        @endif
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'engineer')
          <li class="nav-item">
            <a class="nav-link  {{request()->route()->getName() == 'dashboard.engineer.main' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('dashboard.engineer.main')}}">
              <div class="text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">rocket_launch</i>
              </div>
              <span class="nav-link-text ms-1">Engineer</span>
            </a>
          </li>
        @endif
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor')
        <li class="nav-item">
            <a class="nav-link  {{request()->route()->getName() == 'dashboard.iot-data.main' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('dashboard.iot-data.main')}}">
              <div class="text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">wifi_protected_setup</i>
              </div>
              <span class="nav-link-text ms-1">IOT Visualization</span>
            </a>
          </li>
        @endif
        <li class="nav-item">
          <a class="nav-link text-dark  " href="{{route('logout')}}">
            <div class="text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
        @endauth
        @guest
        <li class="nav-item">
          <a class="nav-link  {{request()->route()->getName() == 'login.login-view' ? 'text-white active bg-gradient-info':'text-dark'}} " href="{{route('login.login-view')}}">
            <div class="text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">login</i>
            </div>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        
        @endguest
        
    @auth
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn text-white w-100" style="background: #d85c36;" href="@{{route('dashboard.new-job')}}" type="button" >Create New Token</a>
      </div>
    </div>
    @endauth
  </aside>