<style>
  .dropdown-toggle::after {
    display: none;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark p-2 bg-dark"
  style="position: fixed; z-index: 1050; width: 100%; top: 0; left: 0;">
  <div class="container-fluid">
    <div class="navbar-brand d-flex align-items-center justify-content-center">
      <i class="bi bi-bandaid-fill text-primary fs-2 me-2"></i>
      <a class="navbar-brand fw-bold text-white" href="/">Healthify</a>
    </div>


    <form class="form-inline d-flex align-items-center justify-content-center" method="GET"
      action="{{ route('threads.search') }}">
      <input class="form-control mx-2" style="min-width: 50vw" type="search" name="search" placeholder="Search...." aria-label="Search">
      <input type="hidden" name="filter" value="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
        <i class="bi bi-search fw-bold"></i>
      </button>
    </form>

    <div class="" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @if(Auth::check())
        <div class="d-flex align-items-center justify-content-center">
          <a class="btn btn-primary border-2 fw-bold mx-4 " href="/threads/create">
            Create
            <i class="bi bi-plus fw-bold"></i>
          </a>
          <div class="dropdown ">
            <div class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
              aria-expanded="false" aria-haspopup="true">
              @if(Auth::user()->profile_photo_path)
              <img src="{{ Auth::user()->profile_photo_path }}" alt="Button Image" class="rounded-circle my-2"
                width="45" height="45">
              @else
              <img src="{{ asset('ProfilePlaceholder.jpg') }}" alt="Button Image" class="rounded-circle my-2" width="45"
                height="45">
              @endif
            </div>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
              <li>
                <li>
                  <a class="dropdown-item text-primary fw-bold" href="{{ route('profile.show', Auth::user()) }}">
                    Profile
                  </a>
                </li>
              </li>
              <li>
                <a class="btn text-primary fw-bold dropdown-item" href="/profile">Settings</a>
              </li>
              <li>
                <form method="POST" class="" action="{{ route('logout') }}">
                  @csrf
                  <a class="btn text-primary fw-bold dropdown-item" :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                  </a>
                </form>
              </li>
            </ul>
          </div>
        </div>
        @else
        <div class="">
          <a class="btn btn-outline-primary border-2 fw-bold " href="/login">Login</a>
          <a class="btn btn-primary ms-2" href="/register">Register</a>
        </div>
        @endif
      </ul>
    </div>
  </div>
</nav>