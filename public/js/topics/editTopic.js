

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