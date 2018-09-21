<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title')
    </title>
    <link href="{{ asset('css/styles.css') }}" type='text/css' rel='stylesheet' />
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/uikit-icons.min.js') }}">
    </script>
    <script src="{{ asset('js/uikit.min.js') }}">
    </script>
</head>
<body>
    <img src="img/logo_high.png" alt="Tri-Cities Wine Hub Logo">
    @if(Session::get('message') != null)
        <div class='alert alert-warning'>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="uk-container">
        <header>
        @yield('header')       
        </header>
        <nav class="uk-navbar-container" uk-navbar uk-sticky>
            <div class="uk-navbar-right">
                <a class="uk-navbar-toggle uk-hidden@s" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-nav" href="#"><span>Menu</span></a>
                <ul class="uk-navbar-nav uk-visible@s" uk-nav>
                    <li class="uk-active"><a href="index.html">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li class="uk-parent">
                        <a href="#">Varietals</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="#">Reds</a></li>
                                <li><a href="#">Whites</a></li>
                                <li><a href="#">Blends</a></li>
                                <li><a href="#">Dessert</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="wine_tasting.html">Tasting</a></li>
                </ul>
            </div>
        </nav>
        <div class="wrapper">
            <div uk-grid>
                <div class="uk-width-2-3@m">

    @yield('content')

</body>
</html>
