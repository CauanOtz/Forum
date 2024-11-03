@extends('layouts.header')

@section('content')
<body>
<div class="landing">
    <div class="sidebar">
        <div class="sidebar-menu">
            <h2>MENU</h2>
            <p class="menu-item" onclick="selectMenuItem(this)"><i class="fa-solid fa-circle-question"></i>Questions</p>
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
            <div class="filters-new filter">
                <p><i class="fa-regular fa-clock"></i>New</p>
            </div>
            <div class="filters-trending filter ">
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
                            <i class="fa-solid fa-chevron-up"></i>
                            <span class="vote-count">{{ $topic->post->votes_count ?? 0 }}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="question">
                            <div class="question-top">
                                <h3 class="question-title">{{ $topic->title }}</h3>
                                <p id="question-date">{{ $topic->created_at->format('H:i a') }}</p>
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
            <button><i class="fa-solid fa-plus" data-bs-toggle="modal" data-bs-target="#createTopicModal"></i>Start a New Topic</button>
        </div>
        <div class="suggestions">
            <h3>Suggestions</h3>
            <div class="suggestions-users">
                <div class="user">
                    <img src="" alt="">
                    <p>Nome</p>
                    <button><i class="fa-solid fa-plus"></i>Follow</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6A2E1A4TuGU6C92Dl7qGWE1Jpw2IdaCk5eAn1KzOH2OV51Xr+S7XnKKKla0j" crossorigin="anonymous"></script>

@endsection