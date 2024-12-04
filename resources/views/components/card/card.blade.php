<div class="cardGeneric">
    <div class="card-top">
        @if($topic->post->user_id === Auth::id())
        <div class="question-crud">
            <button class="edit-topic-btn" data-bs-toggle="modal" data-bs-target="#editTopicModal"
                onclick="openEditModal({{ $topic }})" >
                <i class="fa-solid fa-pen" style="cursor: pointer;"></i>
            </button>

            @endif
            @if($topic->post->user_id === Auth::id())
            <span><strong>|</strong></span>
            @endif
            @if($topic->post->user_id === Auth::id())
            <form action="{{ route('deleteTopicHome', $topic->id) }}" method="POST"
                onsubmit="return confirmDelete(this);;">
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
            <span class="vote-up" data-post="{{ $topic->post->id }}" onclick="ratePost({{ $topic->post->id }}, true)"
                style="cursor: pointer; {{ $topic->post->user_vote === 1 ? 'color: green;' : '' }}">
                <i class="fa-solid fa-chevron-up"></i>
            </span>
            <span class="vote-count" data-post="{{ $topic->post->id }}">{{ $topic->post->votes_count }}</span>
            <span class="vote-down" data-post="{{ $topic->post->id }}" onclick="ratePost({{ $topic->post->id }}, false)"
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
                <a href="{{ route('listTopicById', $topic->id) }}" class="question-title">
                    <h3 class="question-title">{{ $topic->title }}</h3>
                </a>
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
            <p><i class="fa-regular fa-comment" onclick="openCommentModal({{ $topic->post->id }}, {{$topic->id}})"
                    style="cursor: pointer;"></i>
                {{ $topic->comments_count ?? 0 }}</p>
        </div>
    </div>
</div>


<script>

function openEditModal(topic) {
    
    document.getElementById('edit-topic-id').value = topic.id;
    document.getElementById('edit-title').value = topic.title;
    document.getElementById('edit-description').value = topic.description;
    document.getElementById('edit-category').value = topic.category_id;

    var formAction = "{{ url('topics') }}" + '/' + topic.id + '/update-home';
    document.querySelector('#editTopicModal form').setAttribute('action', formAction);
    console.log(formAction);

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