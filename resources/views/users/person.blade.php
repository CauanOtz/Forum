@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/person.css') }}">
@section('content')
<div class="landing">
    @include('layouts.sidebarLeft.sidebar')
    <div class="content">
        <div class="titlePerson">
            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('img/user.png') }}" alt="">
            <h1>{{ $user->name }}</h1>
            <h6>{{ $user->email }}</h6>
        </div>
        @error('name') <span>{{ $message }}</span> @enderror
        <h3 class="titleTopics">Topics</h3>

                @if (isset($topics) && $topics->isNotEmpty())
                @foreach($topics as $topic)
                    @include('components.card.card')
                @endforeach

                @include('components.modals.topics.createTopicModal')
                @include('components.modals.person.personCommentModal')

                @else
                <p>Você ainda não tem tópicos publicados.</p>
                @endif
    </div>
    @include('layouts.sidebarRight.sidebar')
</div>

<script>


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