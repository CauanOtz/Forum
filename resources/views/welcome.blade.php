@extends('layouts.header')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
@section('content')
<body>
<div class="landing">
    @include('layouts.sidebarLeft.sidebar')
    <div class="center">
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
        <div class="filters">
            <div class="filters-new filter {{ request('filter') === 'new' ? 'active' : '' }}" onclick="window.location='{{ route('home', ['filter' => request('filter') === 'new' ? null : 'new']) }}'">
                <p><i class="fa-regular fa-clock"></i>New</p>
            </div>
            <div class="filters-trending filter {{ request('filter') === 'trending' ? 'active' : '' }}" 
                onclick="window.location='{{ route('home', ['filter' => request('filter') === 'trending' ? null : 'trending']) }}'">
                <p><i class="fa-solid fa-turn-up"></i>Trending</p>
            </div>

            <div class="filters-category filter">
                <p><i class="fa-solid fa-sliders"></i>Category</p>
            </div>
        </div>
        <div class="content">
            @foreach($topics as $topic)
                @include('components.card.card')
            @endforeach
        </div>

        @include('components.modals.home.editTopicHomeModal')

        @include('components.modals.home.commentHomeModal')

        @include('components.modals.home.createTopicHomeModal')
    </div>
    @include('layouts.sidebarRight.sidebar')
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

function confirmDelete(form) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Você não poderá reverter esta ação!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); 
        }
    });
    return false; 
}
</script>
@endsection
