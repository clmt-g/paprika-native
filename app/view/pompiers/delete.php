<!-- CSS à ajouter dans le <head> de ta page show -->
<style>
    .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
        color: white;
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 1.5rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.3rem;
    }

    .modal-body {
        padding: 2rem;
        color: #333;
    }

    .modal-body p {
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .modal-body .fw-bold {
        color: var(--rouge-paprika);
    }

    .modal-footer {
        border: none;
        padding: 1.5rem 2rem;
        gap: 0.5rem;
    }

    .modal-footer .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .modal-footer .btn-secondary {
        background-color: #e9ecef;
        color: #333;
        border: none;
    }

    .modal-footer .btn-secondary:hover {
        background-color: #dee2e6;
        transform: translateY(-2px);
    }

    .modal-footer .btn-danger {
        background-color: var(--rouge-paprika);
        border: none;
    }

    .modal-footer .btn-danger:hover {
        background-color: var(--rouge-fonce);
        transform: translateY(-2px);
    }

    .modal-backdrop {
        backdrop-filter: blur(4px);
        background-color: rgba(0, 0, 0, 0.4);
    }
</style>

<!-- HTML de la modale -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Supprimer le pompier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer le pompier <span class="fw-bold">n° {{ $pompier->getMatricule() }}</span> ?</p>
                <p class="text-danger fw-semibold mb-0">
                    <i class="bi bi-shield-exclamation me-2"></i>
                    Cette action est <strong>irréversible</strong>.
                </p>
            </div>
            <div class="modal-footer">
                <a href="/pompiers/show" type="button" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Annuler
                </a>
                <form method="POST" action="/pompiers/delete/{{ $pompier->getMatricule() }}" style="display:inline;">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Oui, supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>