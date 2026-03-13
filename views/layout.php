<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body        { display: flex; min-height: 100vh; background: #f8f9fa; }
        .sidebar    { width: 240px; background: #1B4F8A; color: #fff; display: flex; flex-direction: column; min-height: 100vh; }
        .sidebar .brand { padding: 20px 16px; font-size: 18px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar a  { color: #adb5bd; text-decoration: none; padding: 12px 16px; display: block; font-size: 14px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar .section-label { color: rgba(255,255,255,0.4); font-size: 11px; text-transform: uppercase; padding: 16px 16px 4px; letter-spacing: 1px; }
        .content    { flex: 1; padding: 28px; overflow-y: auto; }
        .sidebar .bottom { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$currentUser = $_SESSION["user"] ?? null;
$currentPage = basename($_SERVER["PHP_SELF"]);
?>

<div class="sidebar">
    <div class="brand">🗂 Task Manager</div>

    <div class="section-label">Navigation</div>
    <a href="/task_manager/views/dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </a>

    <?php if ($currentUser && $currentUser["role"] === "admin"): ?>
        <div class="section-label">Administration</div>
        <a href="/task_manager/controllers/taskController.php?action=list" class="<?= $currentPage === 'list.php' ? 'active' : '' ?>">
            <i class="bi bi-list-check me-2"></i>Toutes les tâches
        </a>
        <a href="/task_manager/controllers/taskController.php?action=create">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle tâche
        </a>
        <a href="/task_manager/controllers/userController.php?action=list">
            <i class="bi bi-people me-2"></i>Utilisateurs
        </a>
        <a href="/task_manager/controllers/taskController.php?action=export">
            <i class="bi bi-download me-2"></i>Exporter CSV
        </a>
    <?php else: ?>
        <div class="section-label">Mes tâches</div>
        <a href="/task_manager/controllers/taskController.php?action=list">
            <i class="bi bi-check2-square me-2"></i>Mes tâches
        </a>
    <?php endif; ?>

    <div class="bottom">
        <a href="/task_manager/controllers/authController.php?logout=1">
            <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
        </a>
        <div style="padding: 10px 16px; font-size: 12px; color: rgba(255,255,255,0.4);">
            <?= htmlspecialchars($currentUser["username"] ?? "") ?>
            <span class="badge bg-secondary ms-1"><?= $currentUser["role"] ?? "" ?></span>
        </div>
    </div>
</div>

<div class="content">