 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- Sidebar -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
         aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="{{ url('/') }}">
         <img src="/assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Student Panel</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="{{ route('student.dashboard') }}">
            <i class="fas fa-home opacity-5"></i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ url('student/subjects') }}">
            <i class="fas fa-book opacity-5"></i>
            <span class="nav-link-text ms-1">Select Subject</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <!-- End Sidebar -->

  <!-- Main Content -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Search...</label>
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
                  <span class="d-none d-md-inline-block">{{ Auth::user()->name ?? 'Student' }}</span>
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
                      <h6 class="mb-0">{{ Auth::user()->name ?? 'Student' }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ Auth::user()->email ?? '' }}</p>
                      <a href="{{ url('student/profile') }}" class="btn btn-xs btn-secondary btn-sm mt-1">View Profile</a>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ url('student/profile') }}">My Profile</a>
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
    <!-- End Navbar -->

    <div class="container-fluid py-4">
      <div class="card">
        <div class="card-header bg-gradient-dark text-white">
          <h5 class="mb-0">Welcome, {{ Auth::user()->name ?? 'Student' }}</h5>
        </div>
        <div class="card-body">
          <p class="text-muted mb-0">
            This is your student dashboard. Use the sidebar to navigate and select your subjects.
          </p>
        </div>
      </div>
    </div>

    <!-- Footer -->
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

  <!-- Core JS Files -->
  <script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="/assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html>
