<div class="modal fade" id="createCommentModal" tabindex="-1" aria-labelledby="createCommentModalLabel"
        aria-hidden="true">
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