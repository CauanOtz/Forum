<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
</head>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/users.css">
<link rel="stylesheet" href="css/landing.css">
<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">
<!-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script> -->
<script src="js/togglePassword.js" defer></script>
<script src="js/toggleModal.js" defer></script>
<script src="js/voteCount.js" defer></script>
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
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="" id="" placeholder="Search for topics">
            </div>
        </div>
        <div class="nav-user">
            <i class="fa-solid fa-bell"></i>
            <div class="nav-profile"></div>
        </div>
    </header>
    <div class="profile" id="profile-modal">
        <i class="fa-solid fa-x profile-modal-close"></i>
        <div class="profile-modal"></div>
        <div class="profile-info">
            <p>{{ Auth::user()->name }}</p>
            <p>{{ Auth::user()->email }}</p>
            <a href="">Minha conta</a>
        </div>
    </div>
    <main>
        @yield('content')
    </main>

</body>
<script src="{{ mix('js/app.js') }}"></script>
</html>

