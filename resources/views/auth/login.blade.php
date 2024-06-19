@extends('layouts.header_footer')

@section('content')
<!-- <div class="container d-flex justify-content-center align-items-center flex-column" style="min-height: 100vh;">
    <h2 class="text-center">Login</h2>
    <form action="{{ route('login')}}" method="POST" class="w-50">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control"  value="{{ old('email') }}" required>
            @error('email') <span>{{$message}}</span> @enderror
        </div>
    
        <div class="mb-3">
            <label for="password" class="form-label">Senha:</label>
            <input type="password" id="password" name="password" class="form-control">
            @error('email') <span>{{$message}}</span> @enderror
        </div>
    
        <input type="submit" class="btn btn-primary" value="Enviar">
    </form>
</div> -->
<div class="container">
    <div class="form-container">
        <div class="form-left">
            <div class="form-title">
                <h1>Sign In</h1>
                <p>Please Sign In to continue</p>
            </div>
            <form action="{{ route('login')}}" method="POST">
                @csrf
                <div class="form-inputs">
                    <input type="email" id="email" name="email" class="form-control"  value="{{ old('email') }}" placeholder="Email | Username" required>         
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-logins">
                    <p>Sign in with OTP</p>
                    <p>Forgot Password?</p>
                </div>

                <input type="submit" value="Login" class="form-btn">

                <div class="form-connections">
                    <p>Or connect with</p>
                    <div>
                        <i>Google</i>
                        <i>Facebook</i>
                        <i>Apple Connect</i>
                    </div>
                    <p>Don't have an account?</p>
                </div>
            </form>
        </div>
        <div class="form-right">
            <img src="https://static.vecteezy.com/system/resources/previews/000/601/617/original/digital-print-logo-design-vector.jpg" alt="">
        </div>
    </div>
</div>
@endsection
