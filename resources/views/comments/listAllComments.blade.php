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
        <button type="button" class="btn btn-purple mb-3" data-bs-toggle="modal"  onclick="toggleModal('createCommentModal')">
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
                        <ul style="max-height: 100px; overflow-y: auto; list-style-type: none; padding: 0;">
                            @foreach($comment->comments->take(3) as $reply)
                            <li title="{{ $reply->content }}"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <strong>{{ $reply->user->name ?? 'Anonymous' }}</strong>:
                                {{ Str::limit($reply->content, 50) }}
                            </li>
                            @endforeach
                        </ul>
                        @if($comment->comments->count() > 3)
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                            data-bs-target="#repliesModal{{ $comment->id }}">
                            View all {{ $comment->comments->count() }} replies
                        </button>

                        @include('components.modals.comments.repliesCommentModal')
                        @endif
                        @else
                        No replies
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editCommentModal{{ $comment->id }}">
                            Edit
                        </button>
                        <form action="{{ route('deleteComment', $comment->id) }}" method="POST" style="display:inline;"
                            class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-button"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @include('components.modals.comments.editCommentModal')
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.modals.comments.createCommentModal')


</div>

@endsection
<script>
document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function(e) {
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