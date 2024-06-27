@extends ('layouts.header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@section('content')
<div class="topic-container">
    <h1>All Topics</h1>
    <a href="{{ route('createTopic')}}" class="topic-btn">Create New Topic</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-striped">
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
                        <a href="{{ route('editTopic', $topic->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('deleteTopic', $topic->id) }}" method="GET" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
