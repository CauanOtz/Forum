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
                <div class="form-low">
                    <input type="submit" value="Login" class="form-btn">
                    <div class="form-connections">
                        <p>Or connect with</p>
                        <div class="connections">
                            <img src="https://img.freepik.com/free-icon/google_318-278809.jpg" alt="">
                            <img src="https://cdn.freebiesupply.com/logos/large/2x/facebook-3-logo-png-transparent.png" alt="">
                            <img src="https://th.bing.com/th/id/R.1ec11a869384bc5e59625bac39b6a099?rik=1dlGqAp84GWGFw&riu=http%3a%2f%2fpngimg.com%2fuploads%2fapple_logo%2fapple_logo_PNG19692.png&ehk=5ghp5P0aLzQqfUKTsPihTYaIP%2b4VcHGKNovcBq8KOuo%3d&risl=&pid=ImgRaw&r=0" alt="">
                        </div>
                        <p>Don't have an account? <strong>Sign Up</strong></p>
                    </div>          
                </div>
                
            </form>
        </div>
        <div class="form-right">
            <img src="https://static.vecteezy.com/system/resources/previews/000/601/617/original/digital-print-logo-design-vector.jpg" alt="">
        </div>
    </div>
</div>
@endsection
