@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/listTopicById.css') }}">
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebarLeft.sidebar')
        </div>

        <div class="col-md-6">
            <div class="card mb-4 shadow-lg border-light rounded">
                <div class="card-body"> 
                    <div class="cardAuthor">
                        <img src="{{ $topic->post->user->photo ? asset('storage/' . $topic->post->user->photo) : asset('img/user.png') }}" alt="" class="imgAuthorTopic">
                        <strong>{{ $topic->post->user->name }}</strong>
                    </div>
                    <h3 class="card-title text-purple font-weight-bold">{{ $topic->title }}</h3>
                    <p class="text-muted mb-3">
                        Posted by <strong>{{ $topic->post->user->name }}</strong> on
                        <span class="badge bg-light text-muted">{{ $topic->created_at->format('M d, Y') }}</span>
                    </p>
                    <p class="card-text">{{ $topic->description }}</p>
                    <div class="d-flex align-items-center gap-4 mt-3">
                        <span class="vote-up" data-post="{{ $topic->post->id }}"
                            onclick="ratePost({{ $topic->post->id }}, true)"
                            style="cursor: pointer; {{ $topic->post->user_vote === 1 ? 'color: #28a745;' : '' }}">
                            <i class="fa-solid fa-thumbs-up fs-4"></i>
                            <span class="ms-2"
                                id="likes-count-{{ $topic->post->id }}">{{ $topic->post->likesCount() ?? 0 }}</span>
                        </span>
                        <span class="vote-down" data-post="{{ $topic->post->id }}"
                            onclick="ratePost({{ $topic->post->id }}, false)"
                            style="cursor: pointer; {{ $topic->post->user_vote === 0 ? 'color: #dc3545;' : '' }}">
                            <i class="fa-solid fa-thumbs-down fs-4"></i>
                            <span class="ms-2"
                                id="dislikes-count-{{ $topic->post->id }}">{{ $topic->post->dislikesCount() ?? 0 }}</span>
                        </span>
                        <p class="mb-0 text-muted d-flex align-items-center">
                            <i class="fa-regular fa-comment me-2"></i>
                            <span>{{ $topic->comments->count() }} comments</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulário de comentário -->
            <h4 class="titleComment">Post a Comment</h4>
            <div class="commentContainer">
                <form action="{{ route('createComment') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                    <input type="hidden" name="post_id" value="{{ $topic->post->id }}">
                    <div class="mb-3">
                        <input type="text" name="content" value="{{ old('content') }}" class="contentComment"
                            placeholder="Write your comment">
                    </div>
                    <button type="submit" class="btn-postComment">Post Comment</button>
                </form>
            </div>

            <!-- Exibição de comentários -->
            <h4 class="mt-4 titleComment">Comments</h4>
            @if($topic->comments->isNotEmpty())
                @foreach($topic->comments as $comment)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <img src="{{ $comment->user->photo ? asset('storage/' . $comment->user->photo) : asset('img/user.png') }}" class="imgComment">
                                <p class="mb-0"><strong>{{ $comment->user->name }}</strong></p>
                            </div>
                            <p class="mb-0 text-muted">{{ $comment->created_at->format('M d, Y') }}</p>
                        </div>
                        <p class="mt-2">{{ $comment->content }}</p>
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-light d-flex align-items-center">
                                <i class="fa-solid fa-thumbs-up"></i> <span class="ms-2">{{ $comment->likes_count ?? 0 }}</span>
                            </button>
                            <button class="btn btn-light d-flex align-items-center">
                                <i class="fa-solid fa-thumbs-down"></i> <span
                                    class="ms-2">{{ $comment->dislikes_count ?? 0 }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <p class="text-muted">No comments yet.</p>
            @endif
        </div>

        <!-- Sidebar direita -->
        <div class="col-md-3">
            @include('layouts.sidebarRight.sidebar')
        </div>
    </div>
</div>

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
                const likesCountElement = document.getElementById(`likes-count-${postId}`);
                const dislikesCountElement = document.getElementById(`dislikes-count-${postId}`);
                if (likesCountElement) likesCountElement.textContent = data.likes_count;
                if (dislikesCountElement) dislikesCountElement.textContent = data.dislikes_count;

                const voteCountElement = document.querySelector(`.vote-count[data-post="${postId}"]`);
                if (voteCountElement) voteCountElement.textContent = data.votes_count;

                const upvoteIcon = document.querySelector(`.vote-up[data-post="${postId}"]`);
                const downvoteIcon = document.querySelector(`.vote-down[data-post="${postId}"]`);

                if (upvoteIcon && downvoteIcon) {
                    if (data.user_vote === 1) {
                        upvoteIcon.style.color = 'green';
                        downvoteIcon.style.color = '';
                    } else if (data.user_vote === 0) {
                        downvoteIcon.style.color = 'red';
                        upvoteIcon.style.color = '';
                    } else {
                        upvoteIcon.style.color = '';
                        downvoteIcon.style.color = '';
                    }
                }
            }
        })
        .catch(error => console.error('Erro:', error));
}
</script>

@endsection
