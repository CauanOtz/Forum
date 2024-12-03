@extends('layouts.header')

@section('content')
<div class="landing">
    @include('layouts.sidebarLeft.sidebar')
    <div class="content">
        <h1>{{ $user->name }}</h1>
        <h6>{{ $user->email }}</h6>
        @error('name') <span>{{ $message }}</span> @enderror

        <div class="settings-content">
            <div class="left">
                <h3>Tópicos</h3>

                @if (isset($topics) && $topics->isNotEmpty())
                @foreach($topics as $topic)
                <div class="card">
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
                        </div>
                        <div class="question">
                            <div class="question-top">
                                <h3 class="question-title">{{ $topic->title }}</h3>
                                <p id="question-date">{{ $topic->created_at->format('H:i a') }}</p>
                                <p class="question-author">Publicado por:
                                    <strong>{{ $topic->post->user->name }}</strong>
                                </p>
                            </div>
                            <p class="question-view">{{ $topic->description }}</p>
                        </div>
                    </div>
                    <div class="views">
                        <p><i class="fa-regular fa-eye"></i>{{ $topic->views_count ?? 0 }}</p>
                        <p><i class="fa-regular fa-comment"
                                onclick="openCommentModal({{ $topic->post->id }}, {{$topic->id}})"
                                style="cursor: pointer;"></i>{{ $topic->comments_count ?? 0 }}</p>
                    </div>

                    <div class="comments-section">
                        @foreach($topic->comments->where('commentable_type', 'App\Models\Post') as $comment)
                        <div class="comment">
                            <div class="comment-info">
                                <span class="comment-author">{{ $comment->user->name ?? 'Anônimo' }}</span>
                                <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p>{{ $comment->content }}</p>
                            <p class="comment-reply-btn"
                                onclick="openReplyModal({{ $topic->post->id }}, {{ $topic->id }}, {{ $comment->id }})">
                                <i class="fa-regular fa-comment"></i> Responder
                            </p>

                            <!-- Exibindo respostas de comentários -->
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

                @include('components.modals.topics.createTopicModal')
                @include('components.modals.person.personCommentModal')

                @else
                <p>Você ainda não tem tópicos publicados.</p>
                @endif
            </div>
        </div>
    </div>
    @include('layouts.sidebarRight.sidebar')
</div>

<script>
function openCommentModal(postId, topicId) {
    document.getElementById('comment-post-id').value = postId;
    document.getElementById('comment-topic-id').value = topicId;
    document.getElementById('comment-commentable-id').value = '';
    document.getElementById('content').value = '';
    new bootstrap.Modal(document.getElementById('createCommentModal')).show();
}

function openReplyModal(postId, topicId, parentCommentId) {
    document.getElementById('comment-post-id').value = postId;
    document.getElementById('comment-topic-id').value = topicId;
    document.getElementById('comment-commentable-id').value = parentCommentId || '';
    document.getElementById('content').value = '';
    new bootstrap.Modal(document.getElementById('createCommentModal')).show();
}

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

</script>
@endsection