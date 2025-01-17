@extends('layouts.header')

@section('content')
<!-- <div class="container d-flex justify-content-center align-items-center flex-column" style="min-height: 100vh;">
    <h2 class="text-center">Perfil</h2>
    <span>{{ session('message') }}</span>
    @if ($user != null)
        <form action="{{route('updateUser' , [$user->id])}}" method="POST" class="w-50">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}" placeholder = "{{$user->name}}" required>
                @error('name') <span>{{$message}}</span> @enderror
            </div>
        
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control"  value="{{$user->email}}" placeholder = "{{$user->email}}"required>
                @error('email') <span>{{$message}}</span> @enderror
            </div>
        
            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" id="password" name="password" value="{{$user->password}}" placeholder = "{{$user->password}}" class="form-control">
                @error('password') <span>{{$message}}</span> @enderror
            </div>
        
            <input type="submit" class="btn btn-primary" value="Enviar">
        </form>
        <form action="{{route('deleteUser' , [$user->id])}}" method="POST" class="w-50">
            @csrf
            @method('delete')
            <input type="submit" class="btn btn-danger" value="Excluir">
        </form>
    @endif
</div> -->
<div class="landing">
    @include('layouts.sidebarLeft.sidebar')
    <div class="content">
        <h1>Public Profile</h1>
        <div class="settings-content">
            <div class="left">
                <form action="{{route('updateUser', [$user->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="{{ $user->name }}" value="{{ $user->name }}"
                        required>
                    @error('name') <span>{{ $message }}</span> @enderror

                    <label for="email">Public Email</label>
                    <input type="text" name="email" id="email" placeholder="{{ $user->email}}" value="{{ $user->email}}"
                        required>
                    @error('email') <span>{{ $message }}</span> @enderror

                    <label for="">Bio</label>
                    <input type="text" placeholder="Tell us a little bit about yourself">

                    <label for="">Pronouns</label>
                    <select name="" id="">
                        <option value="She/her">She/her</option>
                        <option value="He/Him">He Him</option>
                    </select>
                    <label for="photo">Profile Picture</label>
                    <input type="file" name="image" id="image">
                    @error('image') <span>{{ $message }}</span> @enderror

                    <input type="submit" value="Edit" class="profile-btn edit">
                </form>
                <div class="btns">
                    <form action="{{ route('deleteUser', [$user->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="profile-btn delete" value="Delete">
                    </form>
                </div>

            </div>
            <div class="right">
                <p>Profile Picture</p>
                <div class="user-wrapper">
                    <div class="user">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/user.png') }}"
                            alt="Foto de {{ $user->name }}" class="user-photo">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.topics.createTopicModal')
    @include('layouts.sidebarRight.sidebar')
</div>
@endsection