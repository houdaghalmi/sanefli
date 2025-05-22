<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">

    <!-- Site Metas -->
    <title>Login - Sanefli</title>

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- Color CSS -->
    <link id="changeable-colors" rel="stylesheet" href="{{ asset('assets/css/colors/orange.css') }}">
</head>

<body>
    <div id="loader">
        <div id="status"></div>
    </div>

    <div class="reservations-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="form-reservations-box">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                            <h2 class="block-title text-center">Welcome Back</h2>
                        </div>
                        <h4 class="form-title">Sign In to Sanefli</h4>
                        <p>Please enter your credentials to continue</p>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="reservations-box">
                            @csrf

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <input type="email" name="email" id="email" placeholder="Email" required autofocus value="{{ old('email') }}">
                                    <x-input-error :messages="$errors->get('email')" class="text-danger" />
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box">
                                    <input type="password" name="password" id="password" placeholder="Password" required>
                                    <x-input-error :messages="$errors->get('password')" class="text-danger" />
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-box" style="display: flex; justify-content: space-between; align-items: center;">
                                    <label class="remember-box">
                                        <input type="checkbox" name="remember" id="remember_me">
                                        <span class="ms-2">{{ __('Remember me') }}</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-password">
                                            {{ __('Forgot password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="reserve-book-btn text-center">
                                    <button type="submit" class="hvr-underline-from-center">Sign In</button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center" style="margin-top: 20px;">
                            <p>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ALL JS FILES -->
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/all.js') }}"></script>
    <!-- ALL PLUGINS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        $(window).on('load', function() {
            $("#status").fadeOut();
            $("#loader").fadeOut("slow");
        });
    </script>
</body>
</html>
