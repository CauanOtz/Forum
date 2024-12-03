 <!-- Modal for editing comments -->
 <div class="modal fade" id="editCommentModal{{ $comment->id }}" tabindex="-1"
     aria-labelledby="editCommentModalLabel{{ $comment->id }}" aria-hidden="true">
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
                         <textarea name="content" class="form-control"
                             required>{{ old('content', $comment->content) }}</textarea>
                     </div>
                     <div class="mb-3">
                         <label for="image" class="form-label">Image</label>
                         @if($comment->postable && $comment->postable->image)
                         <img src="{{ asset('storage/' . $comment->postable->image) }}" width="100"
                             alt="Comment Image"><br>
                         @endif
                         <input type="file" name="image" class="form-control">
                     </div>
                     <button type="submit" class="btn btn-primary">Update Comment</button>
                 </form>
             </div>
         </div>
     </div>
 </div>