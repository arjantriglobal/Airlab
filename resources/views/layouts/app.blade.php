<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @yield('head')
</head>
<body class="collapsed" onscroll="OnScroll(this);">
    <header>
        <div class="header-buttons">
            <a href="#"><i class="fas fa-arrow-left"></i></a>
            <a href="/"><i class="fas fa-home"></i></a>
        </div>
        <div class="header-title">{{ config('app.name', 'Laravel') }}</div>
        <div class="header-buttons">
            @guest
                <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i></a>
            @else
                <a href="/profile"><i class="fas fa-user-alt"></i></a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest 
        </div>
    </header>
    <nav>
        <span onclick="collapse();" class="nav-button "><i class="fas fa-bars"></i></span>
        <div class="nav-items">
            <a href="/home"><span>Dashboard</span><i class="fas fa-home"></i></a>
            <a href="/profile"><span>Profiel</span><i class="fas fa-user-alt"></i></a>
            <a href="/devices"><span>Apparaten</span><i class="fas fa-laptop"></i></a>
            <a href="/organizations"><span>Organizations</span><i class="fas fa-sitemap"></i></a>
        </div>
        <span class="copyright">&#169;Airlab 2019</span>
    </nav>
    <main>
        <div class="{{ !empty($nopadding) && $nopadding ? "" : "p-2"}}">
            @yield('content')
        </div>
    </main>
    <script type="text/javascript">

        /* this code block is for the header of the page */
        var OnScrollTimeout = null;
        function OnScroll(el){
            if(OnScrollTimeout !== null) clearTimeout(OnScrollTimeout);
            OnScrollTimeout = setTimeout(function(){
                var scrollPosition = Math.round(el.scrollTop);
                if (scrollPosition > 50){ 
                    document.querySelector('body').classList.add('scrolled');
                }
                else {
                    document.querySelector('body').classList.remove('scrolled');
                }
            }, 100);
        }
        /* ---------------------------------------------- */

        function collapse(){
            var body = document.querySelector("body");
            if(body.classList.contains("collapsed")){
                body.classList.remove("collapsed");
            }else{
                body.classList.add("collapsed");
            }
        }

    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
