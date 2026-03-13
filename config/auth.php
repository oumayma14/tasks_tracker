<?php
// ============================================================
// config/auth.php — Fonctions de protection des pages
// À inclure dans chaque contrôleur ou page protégée
// ============================================================

// Vérifie que l'utilisateur est connecté
// Si non → redirige vers la page de login
function requireLogin() {
    // isset() vérifie si la variable de session "user" existe
    if (!isset($_SESSION["user"])) {
        header("Location: /views/login.php");
        exit(); // TOUJOURS exit() après header() pour stopper l'exécution
    }
}

// Vérifie que l'utilisateur est connecté ET qu'il est admin
// Si pas connecté → login  |  Si connecté mais pas admin → dashboard
function requireAdmin() {
    requireLogin(); // D'abord on vérifie la connexion
    if ($_SESSION["user"]["role"] !== "admin") {
        header("Location: /views/dashboard.php");
        exit();
    }
}
