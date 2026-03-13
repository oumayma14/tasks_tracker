<?php include __DIR__ . "/../../layout.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Modifier l'utilisateur #<?= $user["id"] ?></h1>
    <a href="/task_manager/controllers/userController.php?action=list" class="btn btn-outline-secondary btn-sm">← Retour</a>
</div>

<div class="card shadow-sm" style="max-width: 500px;">
    <div class="card-body">
        <form method="POST" action="/task_manager/controllers/userController.php?action=edit">
            <input type="hidden" name="id" value="<?= $user["id"] ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Nom d'utilisateur *</label>
                <input type="text" name="username" class="form-control"
                       value="<?= htmlspecialchars($user["username"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email *</label>
                <input type="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($user["email"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Laisser vide pour ne pas changer">
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Rôle</label>
                <select name="role" class="form-select">
                    <option value="user"  <?= $user["role"] === "user"  ? "selected" : "" ?>>User</option>
                    <option value="admin" <?= $user["role"] === "admin" ? "selected" : "" ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save me-1"></i>Enregistrer
            </button>
        </form>
    </div>
</div>

<?php include __DIR__ . "/../../footer.php"; ?>