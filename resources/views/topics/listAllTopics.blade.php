@extends('layouts.header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@section('content')
<div class="topic-container">
    <h1 class="text-center">All Topics</h1>
    <div class="text-center mb-3">
        <button class="btn-purple" data-bs-toggle="modal" data-bs-target="#createTopicModal">Create New Topic</button>
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
                    <th>Image</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Tag</th>
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
                            @if($topic->post)
                                <img src="{{ asset('img/' . $topic->post->image) }}" alt="Image" width="50">
                            @else
                                <span>No Image</span> 
                            @endif
                        </td>
                        <td>{{ $topic->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $topic->category->title }}</td>
                        <td>
                            @foreach($topic->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->title }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('listTopicById', $topic->id) }}" class="btn btn-success">View</a>
                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTopicModal"
                               data-id="{{ $topic->id }}" data-title="{{ $topic->title }}" 
                               data-description="{{ $topic->description }}" data-status="{{ $topic->status }}"
                               data-category="{{ $topic->category_id }}">Edit</a>
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

@include('components.modals.topics.createTopicModal')
@include('components.modals.topics.editTopicModal')

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
        });
    }

    var editTopicModal = document.getElementById('editTopicModal');
    editTopicModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var topicId = button.getAttribute('data-id');
        var topicTitle = button.getAttribute('data-title');
        var topicDescription = button.getAttribute('data-description');
        var topicStatus = button.getAttribute('data-status');
        var topicCategory = button.getAttribute('data-category');

        editTopicModal.querySelector('#edit-topic-id').value = topicId;
        editTopicModal.querySelector('#edit-title').value = topicTitle;
        editTopicModal.querySelector('#edit-description').value = topicDescription;
        editTopicModal.querySelector('#edit-status').value = topicStatus;
        editTopicModal.querySelector('#edit-category').value = topicCategory;

        var formAction = "{{ url('topics') }}" + '/' + topicId + '/update';
        editTopicModal.querySelector('form').setAttribute('action', formAction);
        console.log(formAction);
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif


</script>
@endsection
