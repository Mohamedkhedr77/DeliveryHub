<div class="navbar bg-base-100 shadow-sm">

  <!-- Left -->
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h7"/>
        </svg>
      </div>

      <ul tabindex="0"
          class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        <li><a>Homepage</a></li>
        <li><a>Portfolio</a></li>
        <li><a>About</a></li>
      </ul>
    </div>
  </div>

  <!-- Center -->
  <div class="navbar-center">
    <a class="btn btn-ghost text-xl">DeliveryHub</a>
  </div>

  <!-- Right -->
  <div class="navbar-end gap-2">

    @auth
      <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp">
          </div>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-44 p-2 shadow">
          <li class="menu-title"><span>{{ auth()->user()->name }}</span></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-right">تسجيل الخروج</button>
            </form>
          </li>
        </ul>
      </div>
    @else
      <a href="{{ route('login') }}" class="btn btn-sm btn-primary">تسجيل الدخول</a>
      <a href="{{ route('register') }}" class="btn btn-sm btn-ghost">إنشاء حساب</a>
    @endauth

  </div>

</div>