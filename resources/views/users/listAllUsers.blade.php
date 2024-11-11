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
                            <a class="btn btn-edit"><i class="fa-solid fa-head-side-cough-slash"></i> Suspender</a>
                            
                            @if($user->is_banned)
                                <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#unbanModal-{{ $user->id }}">
                                    <i class="fa-solid fa-user-check"></i> Desbanir
                                </a>
                            @else
                                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#banModal-{{ $user->id }}">
                                    <i class="fa-solid fa-user-slash"></i> Banir
                                </a>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal para confirmação de banimento -->
                    <div class="modal fade" id="banModal-{{ $user->id }}" tabindex="-1" aria-labelledby="banModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="banModalLabel{{ $user->id }}">Banir Usuário</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Você tem certeza que deseja banir este usuário?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('banUser', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger">Confirmar Banimento</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para confirmação de desbanimento -->
                    <div class="modal fade" id="unbanModal-{{ $user->id }}" tabindex="-1" aria-labelledby="unbanModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="unbanModalLabel{{ $user->id }}">Desbanir Usuário</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Você tem certeza que deseja desbanir este usuário?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('unbanUser', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Confirmar Desbanimento</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
