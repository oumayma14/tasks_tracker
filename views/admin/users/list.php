<?php include __DIR__ . "/../../layout.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Gestion des utilisateurs</h1>
    <a href="/task_manager/controllers/userController.php?action=create" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Nouvel utilisateur
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th><th>Username</th><th>Email</th><th>Rôle</th><th>Créé le</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user["id"] ?></td>
                        <td><?= htmlspecialchars($user["username"]) ?></td>
                        <td><?= htmlspecialchars($user["email"]) ?></td>
                        <td>
                            <span class="badge bg-<?= $user["role"] === "admin" ? "danger" : "secondary" ?>">
                                <?= $user["role"] ?>
                            </span>
                        </td>
                        <td><?= $user["created_at"] ?></td>
                        <td>
                            <a href="/task_manager/controllers/userController.php?action=edit&id=<?= $user["id"] ?>"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="/task_manager/controllers/userController.php?action=delete&id=<?= $user["id"] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Supprimer cet utilisateur ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/../../footer.php"; ?>