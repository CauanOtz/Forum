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

                    <a href="{{ route('question') }}">
                        <p class="menu-item"><i class="fa-regular fa-circle-question"></i>My Questions</p>
                    </a>
                    <a href="{{ route('answers') }}">
                        <p class="menu-item"><i class="fa-regular fa-comments"></i>My Answers</p>
                    </a>
                    <a href="{{ route('likes') }}">
                        <p class="menu-item"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
                    </a>
                    
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
                    <!-- Exibindo os tópicos do usuário como cards -->
                    <h3>Answers</h3>

                    @if (isset($topics) && $topics->isNotEmpty())
                        @foreach($topics as $topic)
                        <div class="card">
                            <div class="card-content">
                                <div class="votes">
                                    <span onclick="ratePost({{ $topic->post->id }}, 1)" style="cursor: pointer;">
                                        <i class="fa-solid fa-chevron-up"></i>
                                    </span>
                                    <span class="vote-count">{{ $topic->post->votes_count ?? 0 }}</span>
                                    <span onclick="ratePost({{ $topic->post->id }}, -1)" style="cursor: pointer;">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                                <div class="question">
                                    <div class="question-top">
                                        <h3 class="question-title">{{ $topic->title }}</h3>
                                        <p id="question-date">{{ $topic->created_at->format('H:i a') }}</p>
                                    </div>
                                    <p class="question-view">{{ $topic->description }}</p>
                                </div>
                            </div>
                            <div class="views">
                                <p><i class="fa-regular fa-eye"></i>{{ $topic->views_count ?? 0 }}</p>
                                <p><i class="fa-regular fa-comment"></i>{{ $topic->comments_count ?? 0 }}</p>
                            </div>
                            <div class="comments-section">
                                @foreach($topic->comments as $comment)
                                <div class="comment">
                                    <p>{{ $comment->content }}</p>
                                    <span>Comentado em: {{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p>Você ainda não tem tópicos publicados.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
