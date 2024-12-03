<div class="modal fade" id="repliesModal{{ $comment->id }}" tabindex="-1"
    aria-labelledby="repliesModalLabel{{ $comment->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="repliesModalLabel{{ $comment->id }}">All Replies
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach($comment->comments as $reply)
                    <li class="list-group-item">
                        <strong>{{ $reply->user->name ?? 'Anonymous' }}</strong>:
                        {{ $reply->content }}
                        <br><small>{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>