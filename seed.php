<?php
// ============================================================
// seed.php — Crée un utilisateur admin par défaut
// À exécuter UNE SEULE FOIS depuis le navigateur : http://localhost/task_manager/seed.php
// Puis SUPPRIME ce fichier (ou restreins l'accès)
// ============================================================
require "config/database.php";
require "models/User.php";

$userModel = new User($pdo);

// Crée l'admin
$ok = $userModel->create("admin", "admin@taskmanager.com", "admin123", "admin");

if ($ok) {
    echo "✅ Admin créé avec succès !<br>";
    echo "Username : <strong>admin</strong><br>";
    echo "Password : <strong>admin123</strong><br>";
    echo "<br>⚠️ Supprime ce fichier maintenant !";
} else {
    echo "❌ Erreur ou utilisateur déjà existant.";
}
