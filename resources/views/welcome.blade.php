@extends('layouts.header')

@section('content')
<body>
<div class="landing">
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
    <div class="center">
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
        <div class="filters">
            <div class="filters-new filter {{ request('filter') === 'new' ? 'active' : '' }}" onclick="window.location='{{ route('home', ['filter' => request('filter') === 'new' ? null : 'new']) }}'">
                <p><i class="fa-regular fa-clock"></i>New</p>
            </div>
            <div class="filters-trending filter {{ request('filter') === 'trending' ? 'active' : '' }}" onclick="window.location='{{ route('home', ['filter' => request('filter') === 'trending' ? null : 'trending']) }}'">
                <p><i class="fa-solid fa-turn-up"></i>Trending</p>
            </div>
            <div class="filters-category filter">
                <p><i class="fa-solid fa-sliders"></i>Category</p>
            </div>
        </div>
        <div class="content">
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
                                <p class="question-author">Publicado por: <strong>{{ $topic->post->user->name }}</strong></p>
                            </div>
                            <p class="question-view">{{ $topic->description }}</p>
                        </div>
                    </div>
                    <div class="views">
                        <p><i class="fa-regular fa-eye"></i>{{ $topic->views_count ?? 0 }}</p>
                        <p><i class="fa-regular fa-comment" onclick="openCommentModal({{ $topic->post->id }}, {{$topic->id}})" style="cursor: pointer;"></i>
                        {{ $topic->comments_count ?? 0 }}</p>
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
        </div>

        
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

        <!-- Create Topic Modal -->
        <div class="modal fade" id="createTopicModal" tabindex="-1" aria-labelledby="createTopicModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTopicModalLabel">Create New Topic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createTopicForm" action="{{ route('createTopic') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="viewName" value="{{request()->routeIs('welcome') ? 'welcome' : 'listAllTopics' }}">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <select class="form-control" id="tags" name="tags[]" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="viewName" value="{{ request()->route()->getName() }}">
                            <button type="submit" class="btn btn-primary">Create Topic</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <div class="topics">
            <button data-bs-toggle="modal" data-bs-target="#createTopicModal"><i class="fa-solid fa-plus" ></i>Start a New Topic</button>
        </div>
        <div class="suggestions">
            <h3>Suggestions</h3>
            <div class="suggestions-users">
                @foreach($suggestedUsers as $user)
                <div class="user">
                    <img src="{{ $user->profile_picture_url }}" alt="">
                    <p>{{ $user->name }}</p>

                    <!-- Formulário individual para cada usuário -->
                    <form action="{{ route('person', ['id' => $user->id]) }}" method="GET">
                        <button type="submit">Profile</button>
                    </form>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
function ratePost(postId, isUpvote) {
    const vote = isUpvote ? 1 : 0;

    fetch(`/posts/${postId}/rate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ vote })
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




    document.querySelector('.filters-new').addEventListener('click', function() {
    const url = new URL(window.location.href); 
    const searchParams = url.searchParams; 

    if (searchParams.get('filter') === 'new') {
        searchParams.delete('filter'); 
    } else {
        searchParams.set('filter', 'new'); 
    }

    window.history.pushState({}, '', url.toString());

    window.location.reload();
});

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

@if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif

</script>
@endsection
