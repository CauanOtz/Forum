@extends('layouts.header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@section('content')

@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif

<div class="comment-container">
    <h1 class="text-center">Comments</h1>
    <div class="text-center mb-3">
        <button type="button" class="btn btn-purple mb-3" data-bs-toggle="modal" data-bs-target="#createCommentModal">
            Create New Comment
        </button>
    </div>

    <div class="table-responsive mx-auto" style="width: 100%;">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Replies</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>
                        @if($comment->postable && $comment->postable->image)
                            <img src="{{ asset('storage/' . $comment->postable->image) }}" width="100" alt="Comment Image">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        @if($comment->comments->isNotEmpty())
                            <ul>
                                @foreach($comment->comments as $reply)
                                    <li>
                                        <strong>{{ $reply->user->name ?? 'Anonymous' }}</strong>: {{ $reply->content }}
                                        <br><small>{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            No replies
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCommentModal{{ $comment->id }}">
                            Edit
                        </button>
                        <form action="{{ route('deleteComment', $comment->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-button" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>

                
                <div class="modal fade" id="editCommentModal{{ $comment->id }}" tabindex="-1" aria-labelledby="editCommentModalLabel{{ $comment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCommentModalLabel{{ $comment->id }}">Edit Comment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('updateComment', $comment->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea name="content" class="form-control" required>{{ old('content', $comment->content) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        @if($comment->postable && $comment->postable->image)
                                            <img src="{{ asset('storage/' . $comment->postable->image) }}" width="100" alt="Comment Image"><br>
                                        @endif
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="createCommentModal" tabindex="-1" aria-labelledby="createCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCommentModalLabel">Create Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createComment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="topic_id" class="form-label">Select Topic</label>
                            <select name="topic_id" class="form-select" required>
                                <option value="">Select a Topic</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" class="form-control" required>{{ old('content') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Create Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não pode ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, deletar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
