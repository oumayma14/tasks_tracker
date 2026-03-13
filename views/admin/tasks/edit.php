<?php include __DIR__ . "/../../layout.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Modifier la tâche #<?= $task["id"] ?></h1>
    <a href="/task_manager/controllers/taskController.php?action=list" class="btn btn-outline-secondary btn-sm">← Retour</a>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="/task_manager/controllers/taskController.php?action=edit">
            <input type="hidden" name="id" value="<?= $task["id"] ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Titre *</label>
                <input type="text" name="titre" class="form-control"
                       value="<?= htmlspecialchars($task["titre"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" rows="4" class="form-control"><?= htmlspecialchars($task["description"]) ?></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="statut" class="form-select">
                        <?php $statuts = ["à faire", "en cours", "terminé"];
                        foreach ($statuts as $s): ?>
                            <option value="<?= $s ?>" <?= $task["statut"] === $s ? "selected" : "" ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Priorité</label>
                    <select name="priorite" class="form-select">
                        <?php $priorites = ["basse", "moyenne", "haute"];
                        foreach ($priorites as $p): ?>
                            <option value="<?= $p ?>" <?= $task["priorite"] === $p ? "selected" : "" ?>><?= ucfirst($p) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Assigner à</label>
                <select name="user_id" class="form-select">
                    <option value="">-- Non assigné --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user["id"] ?>" <?= $task["user_id"] == $user["id"] ? "selected" : "" ?>>
                            <?= htmlspecialchars($user["username"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save me-1"></i>Enregistrer les modifications
            </button>
        </form>
    </div>
</div>

<?php include __DIR__ . "/../../footer.php"; ?>