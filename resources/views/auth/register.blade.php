{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
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
  <!-- Bootstrap CSS -->
  <link href="{{asset('adminui/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/bootstrap-extended.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/style.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/icons.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- loader-->
	<link href="{{asset('adminui/assets/css/pace.min.css')}}" rel="stylesheet" />
  <link href="{{asset('adminui/assets/css/custom.css')}}" rel="stylesheet" />
  <title>Skodash - Bootstrap 5 Admin Template</title>
</head>

<body>

  <!--start wrapper-->
  <div class="wrapper">
    
       <!--start content-->

    <main class="authentication-content">
        <div class="container-fluid sign-in-card">
            <div class="authentication-card">
                <div class="card shadow rounded-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="sign-in-bg  col-lg-6 bg-login d-flex align-items-center justify-content-center">
                            <img height="300"  width="300" src="{{ asset('adminui/assets/images/avatars/logo.webp') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body p-4 p-sm-5">
                               

                                <form method="POST" action="{{ route('register') }}" class="form-body">
                                    @csrf

                                    <div class="login-separater text-center mb-4">
                                        <span>SIGN UP WITH EMAIL</span>
                                        <hr>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12 ">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-person-circle"></i></div>
                                                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name" class="form-control radius-30 ps-5" placeholder="Enter First Name">
                                            </div>
                                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                        </div>

                                        <div class="col-12 mt-4">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-person-circle"></i></div>
                                                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" class="form-control radius-30 ps-5" placeholder="Enter Last Name">
                                            </div>
                                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                        </div>

                                        <div class="col-12 mt-4">
                                            <label for="phone" class="form-label">Phone</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-phone"></i></div>
                                                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" class="form-control radius-30 ps-5" placeholder="Enter Phone Number">
                                            </div>
                                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                        </div>
                                        
                                        <div class="col-12 mt-4">
                                            <label for="email" class="form-label">Email Address</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control radius-30 ps-5" placeholder="Email Address">
                                            </div>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="col-12 mt-4">
                                            <label for="password" class="form-label">Enter Password</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                                                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control radius-30 ps-5" placeholder="Enter Password">
                                            </div>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>
                                        
                                        <div class="col-12 mt-4">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control radius-30 ps-5" placeholder="Confirm Password">
                                            </div>
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        </div>
                                        
                                        <div class="col-12 mt-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">I Agree to the Terms & Conditions</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary radius-30">Sign Up</button>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <p class="mb-0">Already have an account? <a class="sign-up-here" href="{{ route('login') }}">Sign in here</a></p>
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
  <script src="{{asset('adminui/assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('adminui/assets/js/pace.min.js')}}"></script>

  
</body>

</html>