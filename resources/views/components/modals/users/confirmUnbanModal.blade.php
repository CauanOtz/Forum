<div class="modal fade" id="unbanModal-{{ $user->id }}" tabindex="-1" aria-labelledby="unbanModalLabel{{ $user->id }}"
    aria-hidden="true">
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