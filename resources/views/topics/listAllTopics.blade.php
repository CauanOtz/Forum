@extends('layouts.header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@section('content')
<div class="topic-container">
    <h1 class="text-center">All Topics</h1>
    <div class="text-center mb-3">
        <button class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#createTopicModal">Create New Topic</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="table-responsive mx-auto" style="width: 100%;">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ $topic->title }}</td>
                        <td>{{ $topic->description }}</td>
                        <td>
                            <a href="{{ route('listTopicById', $topic->id) }}" class="btn btn-info">View</a>
                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTopicModal" data-id="{{ $topic->id }}" data-title="{{ $topic->title }}" data-description="{{ $topic->description }}">Edit</a>
                            <button class="btn btn-danger" onclick="deleteTopic({{ $topic->id }})">Delete</button>
                            <form id="delete-form-{{ $topic->id }}" action="{{ route('deleteTopic', $topic->id) }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="createTopicModal" tabindex="-1" aria-labelledby="createTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTopicModalLabel">Create New Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTopicForm" action="{{ route('createTopic') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Topic</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTopicModal" tabindex="-1" aria-labelledby="editTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTopicModalLabel">Edit Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTopicForm" action="{{ route('updateTopic', '') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-topic-id" name="topic_id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Topic</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-JFNSi4fY/Mpt/i2//0gqK1tU8W0NzxMD0L4FYV+U8H7vZp0n6eP+k20w0H4xhIgL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-DyZvW+1C0C6/Qu4/TPfgST4L5XgGB6V5pcS7I1cf2HcnUMRZz3RkgbpA/m9ow4B7" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteTopic(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    var editTopicModal = document.getElementById('editTopicModal');
    editTopicModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var topicId = button.getAttribute('data-id');
        var topicTitle = button.getAttribute('data-title');
        var topicDescription = button.getAttribute('data-description');

        var modalTitle = editTopicModal.querySelector('.modal-title');
        var editTopicIdInput = editTopicModal.querySelector('#edit-topic-id');
        var editTopicTitleInput = editTopicModal.querySelector('#edit-title');
        var editTopicDescriptionInput = editTopicModal.querySelector('#edit-description');

        modalTitle.textContent = 'Edit Topic ' + topicTitle;
        editTopicIdInput.value = topicId;
        editTopicTitleInput.value = topicTitle;
        editTopicDescriptionInput.value = topicDescription;

        var formAction = "{{ route('updateTopic', '') }}" + '/' + topicId;
        editTopicModal.querySelector('form').setAttribute('action', formAction);
    });
</script>

@endsection
