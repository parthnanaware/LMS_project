<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>Login - Material Dashboard 3</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
</head>

<body class="">

  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <!-- Left Side Illustration -->
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                   style="background-image: url('{{ asset('assets/img/illustrations/illustration-signin.jpg') }}'); background-size: cover;">
              </div>
            </div>

            <!-- Login Form -->
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="card-header">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to log in</p>
                </div>
                <div class="card-body">

                  @if(session('success'))
                    <div class="alert alert-danger mb-3">
                      {{ session('success') }}
                    </div>
                  @endif

                  <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email"
                             class="form-control @error('email') is-invalid @enderror"
                             value="{{ old('email') }}" required autocomplete="email" autofocus>
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" name="password"
                             class="form-control @error('password') is-invalid @enderror"
                             required autocomplete="current-password">
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="form-check form-switch d-flex align-items-center mb-3">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember"
                             {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label mb-0 ms-2" for="remember">
                        Remember me
                      </label>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-lg bg-gradient-primary w-100 mt-4 mb-0">
                        Sign In
                      </button>
                    </div>
                  </form>
                </div>

                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  @if (Route::has('password.request'))
                    <p class="mb-2 text-sm mx-auto">
                      <a href="{{ route('password.request') }}" class="text-primary text-gradient font-weight-bold">
                        Forgot your password?
                      </a>
                    </p>
                  @endif

                  <p class="text-sm mx-auto mb-0">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Sign Up</a>
                  </p>
                </div>
              </div>
            </div>
            <!-- End Login Form -->
          </div>
        </div>
      </div>
    </section>
  </main>
{{-- here is the all user data or all pages i want ot do the active inactive stutus work if the student is active the it should not be login and dont show admin in the index  --}}
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}"></script>
</body>
</html>
