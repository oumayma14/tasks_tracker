<?php
// ============================================================
// controllers/authController.php — Gère login et logout
// Reçoit le formulaire POST de views/login.php
// ============================================================

session_start(); // Démarre la session (obligatoire pour $_SESSION)

require_once "../config/database.php"; // $pdo disponible
require_once "../models/User.php";     // classe User disponible

$userModel = new User($pdo);

// ── LOGIN ────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {

    // trim() = enlève les espaces avant/après la saisie
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Cherche l'utilisateur en base par son username
    $user = $userModel->findByUsername($username);

    // password_verify() compare le mot de passe saisi avec le hash stocké
    // On vérifie aussi que $user existe (!== false) avant de comparer
    if ($user && password_verify($password, $user["password"])) {

        // session_regenerate_id(true) = change l'ID de session pour éviter
        // les attaques de "session fixation"
        session_regenerate_id(true);

        // On stocke les infos du user dans la session
        // Ces infos seront accessibles sur toutes les pages via $_SESSION["user"]
        $_SESSION["user"] = [
            "id"       => $user["id"],
            "username" => $user["username"],
            "role"     => $user["role"]
        ];

        // Redirige selon le rôle : admin → dashboard admin, user → ses tâches
        if ($user["role"] === "admin") {
            header("Location: /task_manager/views/dashboard.php");
        } else {
            header("Location: /task_manager/controllers/taskController.php?action=list");
        }
        exit();

    } else {
        // Mauvais identifiants : on stocke l'erreur en session
        // pour l'afficher sur la page de login
        $_SESSION["error"] = "Identifiants invalides. Réessayez.";
        header("Location: /task_manager/views/login.php");
        exit();
    }
}

// ── LOGOUT ───────────────────────────────────────────────────
if (isset($_GET["logout"])) {
    session_destroy(); // Supprime toutes les données de session
    header("Location: /task_manager/views/login.php");
    exit();
}
