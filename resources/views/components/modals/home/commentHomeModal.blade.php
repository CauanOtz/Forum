<div class="modal fade" id="createCommentModal" tabindex="-1" aria-labelledby="createCommentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCommentModalLabel">Create New Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCommentForm" action="{{ route('createComment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" id="comment-post-id" value="">
                    <input type="hidden" name="topic_id" id="comment-topic-id" value="">
                    <input type="hidden" name="commentable_id" id="comment-commentable-id" value="">
                    <div class="mb-3">
                        <label for="content" class="form-label">Comment</label>
                        <textarea class="form-control" id="content" name="content" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>