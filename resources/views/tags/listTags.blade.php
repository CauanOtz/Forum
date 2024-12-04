@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/Tags.css') }}">

@section('content')

<body>
    <div class="landing">
        @include('layouts.sidebarLeft.sidebar')
        <div class="center">
            <h1 class="titleTag">Explore Tags</h1>
            <div class="row justify-content-center">
                <div class="containerTag">

                    @if($tags->isNotEmpty())
                    @foreach($tags as $tag)
                    <a href="{{ route('listTagById', $tag->id) }}" style="text-decoration: none;  cursor: pointer;">
                        <div class="cardTag">
                            <h5 class="cardTagTitle">{{ $tag->title }}</h5>
                        </div>
                    </a>
                    @endforeach
                    @else
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <strong>Atenção!</strong> Nenhuma tag encontrada.
                        </div>
                    </div>

                    @endif

                </div>
            </div>
        </div>
        @include('layouts.sidebarRight.sidebar')
        @include('components.modals.home.createTopicHomeModal')
    </div>
</body>


<script>
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

function openReplyModal(postId, topicId, parentCommentId) {
    document.getElementById('comment-post-id').value = postId;
    document.getElementById('comment-topic-id').value = topicId;
    document.getElementById('comment-commentable-id').value = parentCommentId || '';
    document.getElementById('content').value = '';
    new bootstrap.Modal(document.getElementById('createCommentModal')).show();
}
</script>
@endsection