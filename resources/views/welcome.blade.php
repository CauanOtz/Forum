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
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-circle-question"></i>My Questions</p>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-comments"></i>My Answers</p>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
        </div>
        <div class="sidebar-premium">

        </div>
    </div>
    <div class="center">
        <div class="filters">
            <div class="filters-new filter" onclick="window.location='route{{('newestTopics')}}'">
                <p><i class="fa-regular fa-clock"></i>New</p>
            </div>
            <div class="filters-trending filter">
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
                            <span onclick="ratePost({{ $topic->post->id }}, 1)" style="cursor: pointer;">
                                <i class="fa-solid fa-chevron-up"></i>
                            </span>
                            <span class="vote-count">{{ $topic->post->votes_count ?? 0 }}</span>
                            <span onclick="ratePost({{ $topic->post->id }}, -1)" style="cursor: pointer;">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="question">
                            <div class="question-top">
                                <h3 class="question-title">{{ $topic->title }}</h3>
                                <p id="question-date">{{ $topic->created_at->format('H:i a') }}</p>
                                <!-- Alterado para exibir o nome do usuário corretamente -->
                                <p class="question-author">Publicado por: <strong>{{ $user->name }}</strong></p>
                            </div>
                            <p class="question-view">{{ $topic->description }}</p>
                        </div>
                    </div>
                    <div class="views">
                        <p><i class="fa-regular fa-eye"></i>{{ $topic->views_count ?? 0 }}</p>
                        <p><i class="fa-regular fa-comment"></i>{{ $topic->comments_count ?? 0 }}</p>
                    </div>
                    <div class="comments-section">
                        @foreach($topic->comments as $comment)
                            <div class="comment">
                                <p>{{ $comment->content }}</p>
                                <span>Comentado em: {{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
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
    function ratePost(postId, vote) {
    fetch(`/posts/${postId}/rate`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ vote })
})
.then(async (response) => {
    if (!response.ok) {
        const errorMessage = await response.text();  // Captura a resposta de erro em texto
        throw new Error(`Erro na requisição: ${response.status} - ${errorMessage}`);
    }
    return response.json();
})
.then(data => {
    if (data.success) {
        document.querySelector(`.vote-count[data-post="${postId}"]`).innerText = data.new_average;
    } else {
        console.error('Erro no backend:', data.error);
    }
})
.catch(error => console.error('Erro:', error.message));
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
</script>
@endsection
