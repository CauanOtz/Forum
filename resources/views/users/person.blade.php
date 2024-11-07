@extends('layouts.header')

@section('content')
<div class="container">
    <div class="settings-container">
        <div class="sidebar">
            <div class="sidebar">
                <div class="sidebar-menu">
                    <h2>MENU</h2>
                    <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-compass"></i>Explore Topics</p>
                    <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-solid fa-tag"></i>Tags</p>
                </div>
                <div class="sidebar-personalnav">
                    <h2>PERSONAL NAVIGATOR</h2>
                    <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-circle-question"></i>My Questions</p>
                    <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-comments"></i>My Answers</p>
                    <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
                </div>
                <div class="sidebar-premium">

                </div>
            </div>
        </div>
        <div class="content">
        <h1>{{ $user->name }}</h1>
        <h6>{{ $user->email }}</h6>
        @error('name') <span>{{ $message }}</span> @enderror

        <div class="settings-content">
                <div class="left">
                    <!-- Exibindo os posts -->
                    <h3>Posts</h3>
                    @foreach($posts as $post)
                        <div class="post">
                            <!-- Exibindo o título do tópico associado -->
                            
                                <h4><a href="{{ route('listTopicById', $post->topic->id) }}">{{ $post->postable->title}}</a></h4>
                            
                            
                            <p>{{ $post->content }}</p>
                            <small>Publicado em: {{ $post->created_at->format('d/m/Y H:i') }}</small>
                            
                            <!-- Exibindo comentários relacionados ao post -->
                            <h5>Comentários:</h5>
                            
                        </div>
                    @endforeach
                </div>
            </div>

            
            
        </div>
    </div>
</div>
@endsection
