@extends('layouts.header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@section('content')

@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif

<div class="container-users">
    <div class="users-list">
        <h2>Users List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}" data-avatar="{{ $user->avatar }}">Edit</button>

                            
                            @if($user->is_banned)
                                <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#unbanModal-{{ $user->id }}">
                                    <i class="fa-solid fa-user-check"></i> Unban
                                </a>
                            @else
                                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#banModal-{{ $user->id }}">
                                    <i class="fa-solid fa-user-slash"></i> Ban
                                </a>
                            @endif
                        </td>
                    </tr>

                    @include('components.modals.users.confirmBanModal')
                    @include('components.modals.users.editUserModal')
                    @include('components.modals.users.confirmUnBanModal')
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    var editUserModal = document.getElementById('editUserModal');
editUserModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-id');
    var userName = button.getAttribute('data-name');
    var userEmail = button.getAttribute('data-email');
    var userRole = button.getAttribute('data-role');
    var userAvatar = button.getAttribute('data-avatar');

    editUserModal.querySelector('#name').value = userName;
    editUserModal.querySelector('#email').value = userEmail;
    editUserModal.querySelector('#role').value = userRole;
    editUserModal.querySelector('form').setAttribute('action', `/users/${userId}/update`);
});

</script>
