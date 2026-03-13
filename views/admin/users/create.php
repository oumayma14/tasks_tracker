<?php include __DIR__ . "/../../layout.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Nouvel utilisateur</h1>
    <a href="/task_manager/controllers/userController.php?action=list" class="btn btn-outline-secondary btn-sm">← Retour</a>
</div>

<div class="card shadow-sm" style="max-width: 500px;">
    <div class="card-body">
        <form method="POST" action="/task_manager/controllers/userController.php?action=create">
            <div class="mb-3">
                <label class="form-label fw-bold">Nom d'utilisateur *</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email *</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mot de passe *</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Rôle</label>
                <select name="role" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Créer l'utilisateur
            </button>
        </form>
    </div>
</div>

<?php include __DIR__ . "/../../footer.php"; ?>