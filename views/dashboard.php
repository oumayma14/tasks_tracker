<?php
session_start();

require_once "../config/auth.php";
requireLogin();

require_once "../config/database.php";
require_once "../models/Task.php";
require_once "../models/User.php";

$taskModel = new Task($pdo);
$userModel = new User($pdo);

$role      = $_SESSION["user"]["role"];
$userId    = $_SESSION["user"]["id"];
$username  = $_SESSION["user"]["username"];

if ($role === "admin") {
    $totalTasks   = $taskModel->count();
    $totalUsers   = $userModel->count();
    $tasksFaire   = $taskModel->countByStatut("à faire");
    $tasksEnCours = $taskModel->countByStatut("en cours");
    $tasksTermine = $taskModel->countByStatut("terminé");
} else {
    $totalTasks   = $taskModel->countByUser($userId);
    $tasksFaire   = 0;
    $tasksEnCours = 0;
    $tasksTermine = 0;
}

include __DIR__ . "/layout.php";
?>

<h1 class="h4 mb-4">Bonjour, <?= htmlspecialchars($username) ?> 👋</h1>

<?php if ($role === "admin"): ?>
<div class="row g-3 mb-4">
    <?php
    $stats = [
        ["label" => "Total tâches",  "value" => $totalTasks,   "color" => "primary", "icon" => "bi-list-check"],
        ["label" => "À faire",       "value" => $tasksFaire,   "color" => "danger",  "icon" => "bi-hourglass"],
        ["label" => "En cours",      "value" => $tasksEnCours, "color" => "warning", "icon" => "bi-arrow-repeat"],
        ["label" => "Terminées",     "value" => $tasksTermine, "color" => "success", "icon" => "bi-check-circle"],
        ["label" => "Utilisateurs",  "value" => $totalUsers,   "color" => "info",    "icon" => "bi-people"],
    ];
    foreach ($stats as $stat): ?>
        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body py-3">
                    <i class="bi <?= $stat['icon'] ?> fs-3 text-<?= $stat['color'] ?>"></i>
                    <div class="fs-4 fw-bold mt-1"><?= $stat['value'] ?></div>
                    <div class="text-muted small"><?= $stat['label'] ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex gap-2 mb-4">
    <a href="/task_manager/controllers/taskController.php?action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nouvelle tâche
    </a>
    <a href="/task_manager/controllers/taskController.php?action=export" class="btn btn-outline-secondary">
        <i class="bi bi-download me-1"></i>Exporter CSV
    </a>
    <a href="/task_manager/controllers/userController.php?action=list" class="btn btn-outline-secondary">
        <i class="bi bi-people me-1"></i>Gérer les utilisateurs
    </a>
</div>

<?php else: ?>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body py-3">
                <i class="bi bi-list-check fs-3 text-primary"></i>
                <div class="fs-4 fw-bold mt-1"><?= $totalTasks ?></div>
                <div class="text-muted small">Mes tâches</div>
            </div>
        </div>
    </div>
</div>
<a href="/task_manager/controllers/taskController.php?action=list" class="btn btn-primary">
    <i class="bi bi-check2-square me-1"></i>Voir mes tâches
</a>
<?php endif; ?>

<?php include __DIR__ . "/footer.php"; ?>