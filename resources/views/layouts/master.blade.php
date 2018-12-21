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
    <link href="https://fonts.googleapis.com/css?family=Acme|Nunito+Sans|Fahkwang" rel="stylesheet">
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
                <a class="uk-navbar-item uk-logo uk-padding-small uk-visible@l" href="/">
                    <img id="logo" src="/img/logo_high.png" alt="Tri-Cities Wine Hub">
                </a>
                <ul class="uk-navbar-nav" uk-nav>
                    <li class="{{ request()->is('guide*') ? 'uk-active' : '' }}"><a href="/guide">Winery Guide</a></li>
                    <li class="{{ request()->is('avamap*') ? 'uk-active' : '' }}"><a href="/avamap">AVA Map</a></li>
                    @auth
                        <li class="{{ request()->is('planner*') ? 'uk-active' : '' }}"><a href="/planner">Planner</a></li>
                    @endauth
                    <li class="{{ request()->is('about') ? 'uk-active' : '' }}"><a href="/about">About</a></li>
                    <li class="{{ request()->is('contact') ? 'uk-active' : '' }}"><a href="/contact">Contact</a></li>
                </ul>
            </div>
            @guest
                <div class="uk-navbar-right uk-container">
                    <ul class="uk-navbar-nav">
                        @if (!(request()->is('signup')) && !(request()->is('password/*')))
                            <li><a class="uk-text-uppercase uk-nav-item uk-margin-small-right" uk-toggle="target: #login-modal" href="">Login</a></li>
                        @endif
                        <li class="{{ request()->is('signup') ? 'uk-active' : '' }}"><a class="uk-text-uppercase uk-nav-item uk-margin-small-right" href="{{ url('/signup') }}">Signup</a></li>
                    </ul>
                </div>
            @endguest
            @auth
                <div class="uk-navbar-right uk-container">
                    <ul class="uk-navbar-nav">
                        <li class="uk-parent"><a href="#" class="uk-margin-right" uk-icon="icon: user; ratio: 2"><span>User</span></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li class="uk-text-bold uk-text-large uk-padding-top uk-padding-bottom">{{Auth::user()->username}}</li>
                                    {{--<li><a href="/dashboard">My Dashboard</a></li>--}}
                                    <li><a href="/edit">Edit Info</a></li>
                                    <li>
                                        <form method='POST' action='/logout' id='logout-desk' class="uk-width-1-1">
                                            @csrf
                                            <button type='submit' class="uk-margin-top uk-button uk-button-primary">Log Out</button>
                                        </form>
                                    </li>
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
                <a class="uk-logo uk-navbar-item" href="/"><img class="uk-hidden@l" src="/img/logo_high.png" alt="Tri-Cities Wine Hub"></a>
                <div class="uk-navbar-center-right">
                    <a class="uk-padding-large uk-navbar-toggle uk-hidden@l" uk-icon="icon: user; ratio: 2" uk-toggle="target: #offcanvas-user" href="#"><span>User</span></a>
                </div>
            </div>
        </nav>
    </div>
    <div>
        @if(Session::has('status'))
            <div class="uk-alert-primary uk-width-1-1 uk-margin-remove-bottom" uk-alert>
                
                <p class="uk-text-center uk-margin-remove-bottom">{{ Session::get('status') }}</p>
                <a class="uk-alert-close" uk-close></a>
            </div>
        @endif
    </div>
    <div class="wrapper">
        <header class="uk-padding"> 
            @yield('header')
        </header>
        
        @yield('content')
    
        <footer class="uk-text-center uk-container uk-padding-top uk-margin-top">
            <ul class="uk-list">
                <li class="uk-margin-small-right uk-display-inline-block"><a href="https://tcwinehub.tumblr.com/" target="_blank">Blog</a></li>
                <li class="uk-margin-small-left uk-display-inline-block"><a href="/disclaimers">Disclaimers</a></li>
            </ul>
            <p>&copy; 2018 Justin Myre. All Rights Reserved.</p>
        </footer>
    </div>

    <!-- Off-canvas navbar for mobile screens-->
    <!-- Main content nav links -->
    <div class="uk-offcanvas-content">
        <div id="offcanvas-menu" uk-offcanvas="overlay: true; mode: push">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
                    <li class="{{ request()->is('guide') ? 'uk-active' : '' }}"><a href="/guide">Winery Guide</a></li>
                    <li class="{{ request()->is('avamap') ? 'uk-active' : '' }}"><a href="/avamap">AVA Map</a></li>
                    @auth
                        <li class="{{ request()->is('planner') ? 'uk-active' : '' }}"><a href="/planner">Planner</a></li>
                    @endauth
                </ul>
                <hr>
                <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
                    <li class="{{ request()->is('contact') ? 'uk-active' : '' }}"><a href="/about">About</a></li>
                    <li class="{{ request()->is('about') ? 'uk-active' : '' }}"><a href="/contact">Contact</a></li>
                </ul>
            </div>
        </div>
        <!-- User content nav links -->
        <div id="offcanvas-user" uk-offcanvas="flip: true; overlay: true; mode: push">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
                    @guest
                        <li><a uk-toggle="target: #login-modal" href="">Login</a></li>
                        <li class="{{ request()->is('signup*') ? 'uk-active' : '' }}"><a href="/signup">Signup</a></li>
                    @endguest
                    @auth
                        {{--<li class="{{ request()->is('dashboard*') ? 'uk-active' : '' }}"><a href="/dashboard">My Dashboard</a></li>--}}
                        <li class="{{ request()->is('edit*') ? 'uk-active' : '' }}"><a href="/edit">Edit Info</a></li>
                        <li>
                            <form method='POST' action='/logout' id="logout-mobile" class="uk-width-1-1">
                                @csrf
                                <button type='submit' class="uk-button uk-button-primary">Log Out</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
    <!-- Login Form Modal -->
    @if (!(request()->is('signup')) && !(request()->is('password/*')))
        @if ($errors->has('username') || $errors->has('password') || $errors->has('email'))
            <div id="login-modal" class="uk-open" uk-modal style="display: block">
        @else
            <div id="login-modal" uk-modal>
        @endif 
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title">Login</h2>
                <form class="uk-form uk-form-stacked" action="{{ route('login') }}" method="POST" id="login-form">
                    @csrf
                    <div class="uk-form-row uk-margin-top">
                        @if ($errors->has('username') || $errors->has('email'))               
                            <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                            </div>
                        @endif 
                        <label class="visuallyHidden" for="login">Username or Email</label>
                        <div class="uk-inline uk-width-1-1">    
                            <span class="uk-form-icon" uk-icon="icon:user"></span>
                            <input class="uk-input" type="text" name="login" value="{{ old('username') ?: old('email_login') }}" id="login" placeholder="Username or Email" autofocus>
                        </div>
                    </div>
                    <div class="uk-form-row uk-margin-top">
                        @if ($errors->get('password'))              
                            <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <strong>{{ $errors->first('password') }}</strong>    
                            </div>
                        @endif    
                        <label class="visuallyHidden" for="password">Password</label>
                        <div class="uk-inline uk-width-1-1">    
                            <span class="uk-form-icon" uk-icon="icon:lock"></span>
                            <input class="uk-input" type="password" value="{{ old('password') }}" name="password" id="password" placeholder="Password" >
                        </div>
                    </div>
                    <div class="uk-margin-top">        
                        <input class="uk-checkbox" name="remember" value="old('remember') ? 'checked' : '' }}" id="remember" type="checkbox" >
                        <label for="remember">Remember Me </label>
                    </div>
                    <div class="uk-text-right">
                        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                        <button class="uk-button uk-button-primary" type="submit">Log Me In</button>
                    </div>

                    <a class='uk-button uk-button-small' href="/password/reset">Forgot Password?</a>
                </form>
            </div>
        </div>
    @endif
</body>
</html>
