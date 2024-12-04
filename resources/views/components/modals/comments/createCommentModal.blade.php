<div id="createCommentModal" class="custom-modal">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Create Comment</h5>
                <button type="button" class="custom-modal-close" onclick="toggleModal('createCommentModal')">×</button>
            </div>
            <div class="custom-modal-body">
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

<script>
    function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('show');
}

function closeOnBackdrop(event, modalId) {
    const modal = document.getElementById(modalId);
    if (event.target === modal) {
        modal.classList.remove('show');
    }
}

</script>