<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="img/Logo nav.png" type="image/x-icon">
</head>

<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('css/topic.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/btn.css') }}">
<link rel="stylesheet" href="{{ asset('css/comments.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="js/togglePassword.js" defer></script>
<script src="js/toggleModal.js" defer></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
<title> Fórum - Laravel </title>
</head>

<body>
    <header>
        <div class="nav-logo">
            <a href="../">
                <img src="../../../img/Logo nav.png" alt="" href="register">
            </a>
        </div>
        <div class="nav-search">
            <form action="{{ route('searchTopics') }}" method="GET" class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="query" id="" placeholder="Search for topics">
                <button type="submit" style="display: none;"></button>  
            </form>
            
        </div>
        <div class="nav-user">
            <i class="fa-solid fa-bell"></i>
            <div class="nav-profile"></div>
        </div>
    </header>
    <div class="profile" id="profile-modal" > 
        <i class="fa-solid fa-x profile-modal-close"></i>
        <div class="profile-modal"  @guest style="display:none;" @endguest></div>
        <div class="profile-info">
            @auth
                <p>{{ Auth::user()->name }}</p>
                <p>{{ Auth::user()->email }}</p>
                <div class="logout">
                    <a href="{{route('myAccount')}}">My Account</a>
                    <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Exit</a>
                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @else
                <p><a href="{{ route('login') }}">Sign In</a> or <a href="{{ route('register') }}">Sign Up</a></p>
            @endauth
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                <a href="{{ route('routesList') }}">Routes</a>
            @endif

        </div>
    </div>
    <main>
        @yield('content')
    </main>

</body>
<script src="{{ mix('js/app.js') }}"></script>
</html>

