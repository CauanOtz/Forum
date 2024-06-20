<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="js/togglePassword.js" defer></script>
<title> Fórum - Laravel </title>
</head>

<body>
    <header>
        <div class="nav-signup">
            <button>Sign Up</button>
        </div>
    </header>
    <main>
        @yield('content')
    </main>

</body>
<script src="{{ mix('js/app.js') }}"></script>
</html>

