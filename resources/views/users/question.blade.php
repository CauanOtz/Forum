@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/question.css') }}">
@section('content')
<body>
    <div class="landing">
        @include('layouts.sidebarLeft.sidebar')

        <main class="content">
            <header class="questionHeader">
                <h1>{{ $user->name }}</h1>
                <h6>{{ $user->email }}</h6>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </header>

            <section class="settings-content">
                <div class="left">
                    <h3>Questions</h3>

                    @forelse ($topics as $topic)
                    <article class="card">
                        <div class="card-content">
                            @if ($topic->post)
                            <div class="votes">
                                <span class="vote-up" data-post="{{ $topic->post->id }}"
                                    onclick="ratePost({{ $topic->post->id }}, true)"
                                    style="cursor: pointer; {{ $topic->post->user_vote === 1 ? 'color: green;' : '' }}">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </span>
                                <span class="vote-count"
                                    data-post="{{ $topic->post->id }}">{{ $topic->post->votes_count }}</span>
                                <span class="vote-down" data-post="{{ $topic->post->id }}"
                                    onclick="ratePost({{ $topic->post->id }}, false)"
                                    style="cursor: pointer; {{ $topic->post->user_vote === 0 ? 'color: red;' : '' }}">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            @else
                            <p>Este tópico não possui um post associado.</p>
                            @endif

                            <div class="question">
                                <div class="question-top">
                                    <h3 class="question-title">{{ $topic->title }}</h3>
                                    <p class="question-date">{{ $topic->created_at->format('H:i a') }}</p>
                                </div>
                                <p class="question-view">{{ $topic->description }}</p>
                            </div>

                            <div class="tags">
                                @foreach ($topic->tags as $tag)
                                <span class="tag">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        <section class="comments-section">
                            @forelse ($topic->comments as $comment)
                            <div class="comment">
                                <p>{{ $comment->content }}</p>
                                <span>Comentado em: {{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @empty
                            <p>Sem comentários neste tópico.</p>
                            @endforelse
                        </section>
                    </article>
                    @empty
                    <p>Você ainda não tem tópicos publicados.</p>
                    @endforelse
                </div>
            </section>
        </main>
        @include('components.modals.topics.createTopicModal')
        @include('layouts.sidebarRight.sidebar')
    </div>
</body>

<script>
function ratePost(postId, isUpvote) {
    const vote = isUpvote ? 1 : 0;

    fetch(`/posts/${postId}/rate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                vote
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {

                const voteCountElement = document.querySelector(`.vote-count[data-post="${postId}"]`);
                if (voteCountElement) voteCountElement.textContent = data.votes_count;

                const likesElement = document.querySelector(`.likes[data-post="${postId}"]`);
                const dislikesElement = document.querySelector(`.dislikes[data-post="${postId}"]`);
                if (likesElement) likesElement.textContent = data.likes_count;
                if (dislikesElement) dislikesElement.textContent = data.dislikes_count;

                const upvoteIcon = document.querySelector(`.vote-up[data-post="${postId}"]`);
                const downvoteIcon = document.querySelector(`.vote-down[data-post="${postId}"]`);

                if (upvoteIcon && downvoteIcon) {
                    if (data.user_vote === 1) {
                        upvoteIcon.classList.add('voted');
                        downvoteIcon.classList.remove('voted');
                    } else if (data.user_vote === 0) {
                        downvoteIcon.classList.add('voted');
                        upvoteIcon.classList.remove('voted');
                    } else {
                        upvoteIcon.classList.remove('voted');
                        downvoteIcon.classList.remove('voted');
                    }
                }
            }
        })
        .catch(error => console.error('Erro:', error));
}

function selectMenuItem(element) {
    const items = document.querySelectorAll('.menu-item');
    items.forEach(item => item.classList.remove('active'));
    element.classList.add('active');
}


</script>

@endsection