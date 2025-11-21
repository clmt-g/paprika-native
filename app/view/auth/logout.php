<!-- Modal de confirmation de déconnexion -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="bi bi-box-arrow-right"></i> Confirmation de déconnexion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-question-circle text-warning" style="font-size: 3rem;"></i>
                <p class="mt-3 fs-5">Êtes-vous sûr de vouloir vous déconnecter ?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Annuler
                </button>
                <form method="POST" action="/auth/logout" style="display: inline;">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>