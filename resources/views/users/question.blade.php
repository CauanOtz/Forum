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

            <section class="questionContent">

                <h3 class="questionTitle">Questions</h3>

                @forelse ($topics as $topic)
                    @include('components.card.card')
                @empty
                <p>Você ainda não tem tópicos publicados.</p>
                @endforelse
            </section>
        </main>
        @include('components.modals.topics.createTopicModal')
        @include('components.modals.home.commentHomeModal')
        @include('layouts.sidebarRight.sidebar')
    </div>
    @include('components.modals.home.editTopicHomeModal');
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

function openReplyModal(postId, topicId, parentCommentId) {
    document.getElementById('comment-post-id').value = postId;
    document.getElementById('comment-topic-id').value = topicId;
    document.getElementById('comment-commentable-id').value = parentCommentId || '';
    document.getElementById('content').value = ''; 
    new bootstrap.Modal(document.getElementById('createCommentModal')).show();
}

function openCommentModal(postId, topicId) {
    document.getElementById('comment-post-id').value = postId;
    document.getElementById('comment-topic-id').value = topicId;
    document.getElementById('comment-commentable-id').value = ''; 
    document.getElementById('content').value = ''; 
    new bootstrap.Modal(document.getElementById('createCommentModal')).show();
}

function openEditModal(topic) {
    
    document.getElementById('edit-topic-id').value = topic.id;
    document.getElementById('edit-title').value = topic.title;
    document.getElementById('edit-description').value = topic.description;
    document.getElementById('edit-category').value = topic.category_id;

    var formAction = "{{ url('topics') }}" + '/' + topic.id + '/update-home';
    document.querySelector('#editTopicModal form').setAttribute('action', formAction);
    console.log(formAction);

}



</script>

@endsection