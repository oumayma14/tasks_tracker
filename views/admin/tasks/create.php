<?php include __DIR__ . "/../../layout.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Nouvelle tâche</h1>
    <a href="/task_manager/controllers/taskController.php?action=list" class="btn btn-outline-secondary btn-sm">← Retour</a>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="/task_manager/controllers/taskController.php?action=create">
            <div class="mb-3">
                <label class="form-label fw-bold">Titre *</label>
                <input type="text" name="titre" class="form-control" required placeholder="Ex: Corriger le bug login">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" rows="4" class="form-control" placeholder="Détails de la tâche..."></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="statut" class="form-select" required>
                        <option value="à faire">À faire</option>
                        <option value="en cours">En cours</option>
                        <option value="terminé">Terminé</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Priorité</label>
                    <select name="priorite" class="form-select" required>
                        <option value="basse">Basse</option>
                        <option value="moyenne" selected>Moyenne</option>
                        <option value="haute">Haute</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Assigner à</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Choisir un utilisateur --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user["id"] ?>">
                            <?= htmlspecialchars($user["username"]) ?> (<?= $user["role"] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Créer la tâche
            </button>
        </form>
    </div>
</div>

<?php include __DIR__ . "/../../footer.php"; ?>