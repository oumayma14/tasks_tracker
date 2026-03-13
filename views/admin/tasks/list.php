<?php include __DIR__ . "/../../layout.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Toutes les tâches</h1>
    <a href="/task_manager/controllers/taskController.php?action=create" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Nouvelle tâche
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Assigné à</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($tasks) === 0): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Aucune tâche pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= $task["id"] ?></td>
                            <td><?= htmlspecialchars($task["titre"]) ?></td>
                            <td>
                                <?php
                                switch ($task["statut"]) {
                                    case "à faire":  $color = "danger";  break;
                                    case "en cours": $color = "warning"; break;
                                    case "terminé":  $color = "success"; break;
                                    default:         $color = "secondary";
                                }
                                ?>
                                <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($task["statut"]) ?></span>
                            </td>
                            <td>
                                <?php
                                switch ($task["priorite"]) {
                                    case "haute":   $color = "danger";  break;
                                    case "moyenne": $color = "warning"; break;
                                    case "basse":   $color = "info";    break;
                                    default:        $color = "secondary";
                                }
                                ?>
                                <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($task["priorite"]) ?></span>
                            </td>
                            <td><?= htmlspecialchars($task["username"] ?? "Non assigné") ?></td>
                            <td>
                                <a href="/task_manager/controllers/taskController.php?action=edit&id=<?= $task["id"] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/task_manager/controllers/taskController.php?action=delete&id=<?= $task["id"] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer cette tâche ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/../../footer.php"; ?>