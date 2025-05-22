<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sanefli</title>
    
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
                            <h2 class="block-title text-center">Welcome to Your Dashboard</h2>
                        </div>
                        <div class="text-center">
                            <h4>Hello, {{ Auth::user()->name }}!</h4>
                        </div>

                        <!-- Add your dashboard content here -->
                        
                        <div class="text-center" style="margin-top: 20px;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="hvr-underline-from-center">Logout</button>
                            </form>
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
</body>
</html>