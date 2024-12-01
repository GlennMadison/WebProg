<nav class="navbar navbar-expand-lg navbar-dark bg-primary p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Health Forum</a>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <!-- Changed ml-auto to ms-auto for right alignment -->
        <li class="nav-item">
          <a class="nav-link" href="#">Topics</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>

        <li class="nav-item dropdown me-2 ">
          <button class="btn btn-light dropdown-toggle" type="button" role="button" id="dropdownMenuButton"
            data-bs-toggle="dropdown" aria-expanded="false">
            @if (Auth::check())
            {{ Auth::user()->name }}
            @else
            {{ __('Account') }}
            @endif
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <x-dropdown-link class="btn " :href="route('profile.edit')">
              {{ __('Profile') }}
            </x-dropdown-link>
            <form method="POST" class="" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link class="btn" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
              </x-dropdown-link>
            </form>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>