{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!doctype html>
<html lang="en" class="minimal-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="icon" href="{{asset('adminui/assets/images/favicon-32x32.png')}}" type="image/png" />
  <!--plugins-->
  <link href="{{asset('adminui/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="{{asset('adminui/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/bootstrap-extended.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/style.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/icons.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

  <!-- loader-->
	<link href="{{asset('adminui/assets/css/pace.min.css')}}" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="{{asset('adminui/assets/css/dark-theme.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/light-theme.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/semi-dark.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/header-colors.css')}}" rel="stylesheet" />
    <link href="{{asset('adminui/assets/css/custom.css')}}" rel="stylesheet" />


  <title>Skodash - Bootstrap 5 Admin Template</title>
</head>

<body>

  <!--start wrapper-->
  <div class="wrapper">
    

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <main class="authentication-content">
        <div class="container-fluid sign-in-card">
            <div class="authentication-card">
                <div class="card shadow rounded-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="sign-in-bg col-lg-6 bg-login d-flex align-items-center justify-content-center">
                            <img height="300" width="300" src="{{ asset('adminui/assets/images/avatars/logo.webp') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body p-4 p-sm-5">
                             

                                <form method="POST" action="{{ route('login') }}" class="form-body">
                                    @csrf

                                    <div class="login-separater text-center mb-4">
                                        <span> SIGN IN WITH EMAIL</span>
                                        <hr>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email Address</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="form-control radius-30 ps-5" placeholder="Email Address">
                                            </div>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Enter Password</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                                                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control radius-30 ps-5" placeholder="Enter Password">
                                            </div>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <div class="col-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                                <label class="form-check-label" for="remember_me">Remember Me</label>
                                            </div>
                                        </div>

                                        <div class="col-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a class="forget-password" href="{{ route('password.request') }}">Forgot Password ?</a>
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary radius-30">Sign In</button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <p class="mb-0">Don't have an account yet? <a class="sign-up-here" href="{{route('register')}}">Sign up here</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
 
        
       <!--end page main-->

  </div>
  <!--end wrapper-->


  <!--plugins-->
 <!-- Bootstrap bundle JS -->
  <script src="{{asset('adminui/assets/js/bootstrap.bundle.min.js')}}"></script>
  <!--plugins-->
  <script src="{{asset('adminui/assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/easyPieChart/jquery.easypiechart.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/peity/jquery.peity.min.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
  <script src="{{asset('adminui/assets/js/pace.min.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
	<script src="{{asset('adminui/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
  <script src="{{asset('adminui/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('adminui/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
  <!--app-->
  <script src="{{asset('adminui/assets/js/app.js')}}"></script>
  <script src="{{asset('adminui/assets/js/index.js')}}"></script>

  <script>
     new PerfectScrollbar(".best-product")
     new PerfectScrollbar(".top-sellers-list")
  </script>



</body>

</html>