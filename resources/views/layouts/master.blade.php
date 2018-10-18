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
    <link href="https://fonts.googleapis.com/css?family=Courgette|Source+Serif+Pro|Source+Sans+Pro" rel="stylesheet">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/uikit.min.js') }}">
    </script>
    <script src="{{ asset('js/uikit-icons.min.js') }}">
    </script>
</head>
<body>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
        <nav class="uk-navbar-container uk-padding-remove uk-visible@l" uk-navbar>
            <div class="uk-navbar-left uk-container">
                <a class="uk-navbar-item uk-logo uk-padding-small uk-visible@l" href="#">
                    <img id="logo" src="/img/logo_high.png" alt="Tri-Cities Wine Hub">
                </a>
                <ul class="uk-navbar-nav" uk-nav>
                    <li class="{{ request()->is('guide*') ? 'uk-active' : '' }}"><a href="{{ url('/guide') }}">Winery Guide</a></li>
                    <li class="{{ request()->is('avamap*') ? 'uk-active' : '' }}"><a href="{{ url('/avamap') }}">AVA Map</a></li>
                    @auth
                        <li class="{{ request()->is('planner*') ? 'uk-active' : '' }}"><a href="{{ url('/planner') }}">Planner</a></li>
                    @endauth
                    {{--<li class="{{ request()->is('about') ? 'uk-active' : '' }}"><a href="{{ url('/about') }}">About</a></li>--}}
                    <li><a href="https://tcwinehub.tumblr.com/" target="_blank">Blog</a></li>
                    <li class="{{ request()->is('contact') ? 'uk-active' : '' }}"><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>
            @guest
                <div class="uk-navbar-right uk-container">
                    <ul class="uk-navbar-nav">
                        <li><a class="uk-text-uppercase uk-nav-item uk-margin-small-right" uk-toggle="target: #login-modal" href="">Login</a></li>
                        <li><a class="uk-text-uppercase  uk-nav-item uk-margin-small-right" href="{{ url('/signup') }}">Signup</a></li>
                    </ul>
                </div>
            @endguest
            @auth
                <div class="uk-navbar-right uk-visible@l">
                    <ul class="uk-navbar-nav uk-visible@l uk-navbar-right">
                        <li class="uk-parent"><a href="#" class="uk-margin-right" uk-icon="icon: user; ratio: 2"><span>User</span></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li>USERNAME</li>
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Tasting Planner</a></li>
                                    <li><a href="#">Wine Journal</a></li>
                                    <li><a href="#">Edit Info</a></li>
                                    <li><a href="#">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            @endauth
        </nav>
        <nav class="uk-navbar-container uk-padding-remove uk-hidden@l" uk-navbar>
            <div class="uk-navbar-center">
                <div class="uk-navbar-center-left">
                    <a class="uk-padding-large uk-navbar-toggle" uk-icon="icon: menu; ratio: 2" uk-toggle="target: #offcanvas-menu" href="#"><span>Menu</span></a>
                </div>
                <a class="uk-logo uk-navbar-item"><img class="uk-hidden@l" src="/img/logo_high.png" alt="Tri-Cities Wine Hub"></a>
                <div class="uk-navbar-center-right">
                    <a class="uk-padding-large uk-navbar-toggle uk-hidden@l" uk-icon="icon: user; ratio: 2" uk-toggle="target: #offcanvas-user" href="#"><span>User</span></a>
                </div>
            </div>
        </nav>
    </div>
    <div class="uk-container wrapper">
        <header class="uk-padding-large"> 
            @yield('header')
        </header>
        @if(Session::get('message') != null)
            <div class='uk-alert uk-alert-warning'>
                {{ Session::get('message') }}
            </div>
        @endif
        @yield('content')
    </div>
    <footer class="uk-text-center">
        <p>&copy; 2018 Justin Myre. All Rights Reserved.</p>
    </footer>
        <!-- Login Form Modal -->
    <div id="login-modal" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title">User Login</h2>
            <form class="uk-form uk-form-stacked" action="/login" method="post" id="login-form">
                <div class="uk-form-row"> 
                    <label class="visuallyHidden" for="user">User Name</label>
                    <div class="uk-inline uk-width-1-1"> 
                        <span class="uk-form-icon" uk-icon="icon:user"></span>
                        <input class="uk-input" type="text" id="user" placeholder="User Name" required>
                    </div>
                </div>
                <div class="uk-form-row uk-margin-top">        
                    <label class="visuallyHidden" for="password">Password</label>
                    <div class="uk-inline uk-width-1-1">    
                        <span class="uk-form-icon" uk-icon="icon:lock"></span>
                        <input class="uk-input" type="text" id="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="uk-margin-top">        
                    <label class="uk-form-label" for="remember">Remember Me</label>   
                    <input class="uk-checkbox uk-form-controls-text" type="checkbox" id="remember">
                </div>
                <p class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    <button class="uk-button uk-button-primary" type="submit">Login</button>
                </p>
            </form>
        </div>
    </div>
    <!-- Off-canvas navbar -->
    <div class="uk-offcanvas-content">
        <div id="offcanvas-menu" uk-offcanvas="overlay: true; mode: push">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
                    <li><a href="{{ url('/guide') }}">Winery Guide</a></li>
                    <li><a href="{{ url('/avamap') }}">AVA Map</a></li>
                    @auth
                        <li><a href="{{ url('/planner') }}">Planner</a></li>
                    @endauth
                </ul>
                <hr>
                <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
                    {{--<li><a href="{{ url('/about') }}">About</a></li>--}}
                    <li><a href="https://tcwinehub.tumblr.com/">Blog</a></li>
                    <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div id="offcanvas-user" uk-offcanvas="flip: true; overlay: true; mode: push">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
                    @guest
                        <li><a href="">Login</a></li>
                        <li class="{{ request()->is('signup*') ? 'uk-active' : '' }}"><a href="{{ url('/signup') }}">Signup</a></li>
                    @endguest
                    @auth
                        <li class="{{ request()->is('dashboard*') ? 'uk-active' : '' }}"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="{{ request()->is('profile*') ? 'uk-active' : '' }}"><a href="{{ url('/account') }}">Edit Info</a></li>
                        <li><a href="{{ url('/logout') }}">Logout</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
