    <!DOCTYPE html>
    <html lang="en">

    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>Material Dashboard 3 - Admin Panel</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    </head>
    <body class="g-sidenav-show bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
        <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="{{ url('/') }}">
            <img src="/assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
            <span class="ms-1 text-sm text-dark">Admin Panel</span>
        </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active bg-gradient-dark text-white" href="{{ url('/') }}">
                <i class="material-symbols-rounded opacity-5">dashboard</i>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-dark" href="{{ url('student') }}">
                <i class="material-symbols-rounded opacity-5">table_view</i>
                <span class="nav-link-text ms-1">Student </span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-dark" href="{{ url('subject') }}">
                <i class="material-symbols-rounded opacity-5">receipt_long</i>
                <span class="nav-link-text ms-1">Subject </span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-dark" href="{{ url('corse') }}">
                <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                <span class="nav-link-text ms-1">corse</span>
            </a>
            </li>
            {{-- <li class="nav-item">
            <a class="nav-link text-dark" href="{{ url('session') }}">
                <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
                <span class="nav-link-text ms-1">Session List</span>
            </a>
            </li> --}}
        </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        </div>
    </aside>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                <label class="form-label">Type here...</label>
                <input type="text" class="form-control">
                </div>
            </div>
            <ul class="navbar-nav d-flex align-items-center justify-content-end">
                <li class="nav-item dropdown pe-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/profiles/' . Auth::user()->photo) }}" class="avatar-img rounded-circle">
                        @else
                            <img src="/assets/img/default-avatar.png" class="avatar-img rounded-circle">
                        @endif
                    </div>
                    <span class="d-none d-md-inline-block">{{ Auth::user()->name ?? 'User' }}</span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="dropdownProfile">
                    <li class="mb-2">
                    <div class="d-flex align-items-center px-3">
                        <div class="avatar avatar-sm me-2">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/profiles/' . Auth::user()->photo) }}" class="avatar-img rounded-circle">
                            @else
                                <img src="/assets/img/default-avatar.png" class="avatar-img rounded-circle">
                            @endif
                        </div>
                        <div class="d-flex flex-column">
                        <h6 class="mb-0">{{ Auth::user()->name ?? 'User' }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ Auth::user()->email ?? '' }}</p>
                        <a href="profile" class="btn btn-xs btn-secondary btn-sm mt-1">View Profile</a>
                        </div>
                    </div>
                    </li>
                    <li>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="profile">My Profile</a>

                    <div class="dropdown-divider"></div>
                   <form action="{{ route('logout') }}" method="POST">
  @csrf
  <button type="submit" class="dropdown-item text-danger">Log Out</button>
</form>

                    </li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
        </nav>

        <div class="container-fluid py-4">
        @yield('admincontent')
        </div>

       <footer class="footer py-4 bg-light" style="position: fixed; bottom: 0; width: 100%; z-index: 1000;">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>document.write(new Date().getFullYear())</script>,
                    made with <i class="fa fa-heart text-danger"></i> by
                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                </div>
            </div>
        </div>
    </div>
</footer>

    </main>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/material-dashboard.min.js?v=3.2.0"></script>
    </body>

    </html>
