<nav class="navbar navbar-expand-md  bg-white text-dark "
  style="justify-content: space-between ;border-bottom:1px solid #eee;height: 10vh;">
  <!-- Brand -->
  <a class=" navbar-brand pl-3" href="#"><img src="{{secure_asset('storage/image/logo.png')}}"
      style="height: 50px;"></a>


  <ul class="navbar-nav ">
    <!-- Dropdown -->
    <li class="nav-item ">
      <a class="nav-link   text-dark" href="/"><i class='fas fa-globe text-secondary small'></i>
        Website</a>


    </li>
    <li class="nav-item ">
      <a class="nav-link   text-dark" href="{{route('login.logoutadmin')}}"><i class='fas fa-sign-out-alt text-secondary small'></i>
        Logout</a>


    </li>
    <li class="nav-item ">
      <a class="nav-link   text-dark" href="/dashboard/account"><i class='fas fa-cogs text-secondary small'></i>
        Account</a>

    </li>

  </ul>
</nav>