<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" action="{{ route('updateCategory', '') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-category-id" name="category_id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                        <label for="edit-description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="edit-description" name="description" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>