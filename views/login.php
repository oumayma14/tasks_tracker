<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion — Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { max-width: 420px; width: 100%; }
    </style>
</head>
<body>
<?php
// Démarre la session pour lire le message d'erreur éventuel
if (session_status() === PHP_SESSION_NONE) session_start();

// Récupère l'erreur stockée par authController.php (ou chaîne vide)
$error = $_SESSION["error"] ?? "";
// Supprime l'erreur de la session après l'avoir lue (évite qu'elle s'affiche en boucle)
unset($_SESSION["error"]);
?>

<div class="card shadow p-4">
    <h2 class="mb-1 text-primary fw-bold">🗂 Task Manager</h2>
    <p class="text-muted mb-4">Connectez-vous pour continuer</p>

    <?php if ($error): ?>
        <!-- Affichage conditionnel de l'erreur — if/else du cours -->
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- action pointe vers le contrôleur qui va traiter le formulaire -->
    <form method="POST" action="../controllers/authController.php">
        <div class="mb-3">
            <label class="form-label fw-bold">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <!-- name="login" permet à authController de détecter ce formulaire via isset($_POST["login"]) -->
        <button type="submit" name="login" class="btn btn-primary w-100">Se connecter</button>
    </form>
</div>

</body>
</html>
