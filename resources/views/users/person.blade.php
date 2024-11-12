@extends('layouts.header')

@section('content')
<div class="container">
    <div class="settings-container">
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
            <div class="sidebar-premium"></div>
        </div>
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
                                        <span onclick="ratePost({{ $topic->post->id }}, true)" style="cursor: pointer;">
                                            <i class="fa-solid fa-chevron-up"></i>
                                        </span>
                                        <span class="vote-count">{{ $topic->post->votes_count ?? 0 }}</span>
                                        <span onclick="ratePost({{ $topic->post->id }}, false)" style="cursor: pointer;">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </span>
                                    </div>
                                    <div class="question">
                                        <div class="question-top">
                                            <h3 class="question-title">{{ $topic->title }}</h3>
                                            <p id="question-date">{{ $topic->created_at->format('H:i a') }}</p>
                                            <p class="question-author">Publicado por: <strong>{{ $topic->post->user->name }}</strong></p>
                                        </div>
                                        <p class="question-view">{{ $topic->description }}</p>
                                    </div>
                                </div>
                                <div class="views">
                                    <p><i class="fa-regular fa-eye"></i>{{ $topic->views_count ?? 0 }}</p>
                                    <p><i class="fa-regular fa-comment" onclick="openCommentModal({{ $topic->post->id }}, {{$topic->id}})" style="cursor: pointer;"></i>{{ $topic->comments_count ?? 0 }}</p>
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

                        <!-- Modal do comentário -->
                        <div class="modal fade" id="createCommentModal" tabindex="-1" aria-labelledby="createCommentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createCommentModalLabel">Create New Comment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="createCommentForm" action="{{ route('createComment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="post_id" id="comment-post-id" value="">
                                            <input type="hidden" name="topic_id" id="comment-topic-id" value="">
                                            <input type="hidden" name="commentable_id" id="comment-commentable-id" value="">
                                            <div class="mb-3">
                                                <label for="content" class="form-label">Comment</label>
                                                <textarea class="form-control" id="content" name="content" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        <p>Você ainda não tem tópicos publicados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
</script>
@endsection

