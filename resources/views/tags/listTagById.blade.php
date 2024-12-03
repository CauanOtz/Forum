@extends('layouts.header')

@section('content')
<div class="landing">
<!-- <h1 class="text-center">Tópicos com a Tag: {{ $tag->title }}</h1> -->

    <div class="sidebar">
        <div class="sidebar-menu">
            <h2>MENU</h2>
            <a class="menu-item" onclick="selectMenuItem(this)" href="{{ route('home') }}"><i class="fa-regular fa-compass"></i>Explore Topics</a>
            <a class="menu-item" onclick="selectMenuItem(this)" href="{{ route('showTags') }}" ><i class="fa-solid fa-tag"></i>Tags</a>
        </div>
        <div class="sidebar-personalnav">
            <h2>PERSONAL NAVIGATOR</h2>
                <a href="{{ route('question') }}">
                    <p class="menu-item"><i class="fa-regular fa-circle-question"></i>My Questions</p>
                </a>
                <!-- <a href="{{ route('answers') }}">
                    <p class="menu-item"><i class="fa-regular fa-comments"></i>My Answers</p>
                </a>
                <a href="{{ route('likes') }}">
                    <p class="menu-item"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
                </a>  Sem funcionamento (Em desenvolvimento) -->
        </div>
        <div class="sidebar-premium">

        </div>
    </div>
    <div class="center">
    @if($topics->isNotEmpty())
            @foreach($topics as $topic)
            <div class="card">
                    <div class="card-top">
                        
                            @if($topic->post->user_id === Auth::id())
                            <div class="question-crud">
                                <button 
                                    class="edit-topic-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editTopicModal" 
                                    onclick="openEditModal({{ $topic }})">
                                    <i class="fa-solid fa-pen" style="cursor: pointer;"></i>
                                </button>
                                
                                @endif
                                @if($topic->post->user_id === Auth::id())
                                <span><strong>|</strong></span>
                                @endif
                                @if($topic->post->user_id === Auth::id())
                                    <form action="{{ route('deleteTopicHome', $topic->id) }}" method="POST" onsubmit="return confirmDelete(this);;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-topic-btn">
                                            <i class="fa-solid fa-trash" style="color: red; cursor: pointer;"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                       
                    </div>
                    <div class="card-content">
                        <div class="votes">
                            <span class="vote-up" data-post="{{ $topic->post->id }}" 
                                onclick="ratePost({{ $topic->post->id }}, true)" 
                                style="cursor: pointer; {{ $topic->post->user_vote === 1 ? 'color: green;' : '' }}">
                                <i class="fa-solid fa-chevron-up"></i>
                            </span>
                            <span class="vote-count" data-post="{{ $topic->post->id }}">{{ $topic->post->votes_count }}</span>
                            <span class="vote-down" data-post="{{ $topic->post->id }}" 
                                onclick="ratePost({{ $topic->post->id }}, false)" 
                                style="cursor: pointer; {{ $topic->post->user_vote === 0 ? 'color: red;' : '' }}">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
<!-- 
                            <div class="vote-details">
                                <div class="likes" data-post="{{ $topic->post->id }}">
                                    <i class="fa-solid fa-thumbs-up"></i> {{ $topic->post->likes_count ?? 0 }}
                                </div>
                                <div class="dislikes" data-post="{{ $topic->post->id }}">
                                    <i class="fa-solid fa-thumbs-down"></i> {{ $topic->post->dislikes_count ?? 0 }}
                                </div>
                            </div> -->

                        </div>

                        <div class="question">
                            <div class="question-top">
                                <h3 class="question-title">{{ $topic->title }}</h3>
                                <p id="question-date">{{ $topic->created_at->format('H:i a') }}</p>
                               
                            </div>
                            <p class="question-view">{{ $topic->description }}</p>
                        </div>
                    </div>
                   
                    <div class="card-low">
                        <div class="question-author">
                                <p class="question-author">Publicado por: <strong>{{ $topic->post->user->name }}</strong></p>
                        </div>  
                        <div class="views">
                            <p><i class="fa-regular fa-eye"></i>{{ $topic->views_count ?? 0 }}</p>
                            <p><i class="fa-regular fa-comment" onclick="openCommentModal({{ $topic->post->id }}, {{$topic->id}})" style="cursor: pointer;"></i>
                            {{ $topic->comments_count ?? 0 }}</p>
                        </div>
                    </div>
                    
                    <div class="comments-section">
                        @foreach($topic->comments->where('commentable_type', 'App\Models\Post') as $comment)
                            <div class="comment">
                                <div class="comment-info">
                                    <span class="comment-author">{{ $comment->user->name ?? 'Anônimo' }}</span>
                                    <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p>{{ $comment->content }}</p>
                                <p class="comment-reply-btn" onclick="openReplyModal({{ $topic->post->id }}, {{ $topic->id }}, {{ $comment->id }})">
                                    <i class="fa-regular fa-comment"></i> Responder
                                </p>

                                @foreach($comment->comments as $reply)
                                    <div class="comment-reply">
                                        <div class="comment-info">
                                            <span class="comment-author">{{ $reply->user->name ?? 'Anônimo' }}</span>
                                            <span>{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <p>{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        Nenhum tópico encontrado para essa tag.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
       
   
@endsection
