<div class="modal fade" id="banModal-{{ $user->id }}" tabindex="-1" aria-labelledby="banModalLabel{{ $user->id }}"
    aria-hidden="true">
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

