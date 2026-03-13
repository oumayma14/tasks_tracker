<?php include __DIR__ . "/../layout.php"; ?>

<h1 class="h4 mb-4">Mes tâches</h1>

<?php if (count($tasks) === 0): ?>
    <div class="alert alert-info">Vous n'avez aucune tâche assignée pour le moment.</div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($tasks as $task): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($task["titre"]) ?></h5>
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars($task["description"] ?: "Pas de description.") ?>
                        </p>
                        <?php
                        switch ($task["priorite"]) {
                            case "haute":   $pc = "danger";  break;
                            case "moyenne": $pc = "warning"; break;
                            default:        $pc = "info";
                        }
                        ?>
                        <span class="badge bg-<?= $pc ?> mb-3">Priorité : <?= $task["priorite"] ?></span>
                        <form method="POST" action="/task_manager/controllers/taskController.php?action=statut">
                            <input type="hidden" name="id" value="<?= $task["id"] ?>">
                            <label class="form-label small fw-bold">Statut actuel</label>
                            <div class="input-group">
                                <select name="statut" class="form-select form-select-sm">
                                    <?php $statuts = ["à faire", "en cours", "terminé"];
                                    foreach ($statuts as $s): ?>
                                        <option value="<?= $s ?>" <?= $task["statut"] === $s ? "selected" : "" ?>><?= ucfirst($s) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-muted small">Créé le <?= $task["created_at"] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . "/../footer.php"; ?>