<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('header/title')
        <title>{{ config('app.name', 'Reviews van Klanten') }}</title>
    @show

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('header/scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('header/styles')
</head>
<body>
<header class="py-4 bg-primary">
    <div class="container mx-auto lg:flex">
        <nav class="ml-auto top-nav">
            @guest
                <a href="{{ route('login') }}" class="mr-2">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="pill bg-black text-white">{{ __('Register') }}</a>
            @endguest

            @auth
                <a href="{{ route('logout') }}" onclick="event => event.preventDefault; document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </a>
                <a href="{{ route('home') }}" class="pill bg-black text-white ml-4">Dashboard</a>
            @endauth
        </nav>
    </div>
</header>
<header class="bg-primary-800 py-4 shadow">
    <div class="container mx-auto lg:flex">
        <a class="'navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Reviews van klanten') }}
        </a>

        <nav class="navbar lg:ml-auto">
            <a href="#" class="mr-4">Home</a>
            <a href="#" class="mr-4">Voordelen</a>
            <a href="#" class="mr-4">Tarieven</a>
            <a href="#">Contact</a>
        </nav>
    </div>
</header>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" hidden>
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
