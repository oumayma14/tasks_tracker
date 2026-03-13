<?php
// ============================================================
// config/database.php — Connexion PDO à MySQL
// Inclus dans tous les fichiers qui ont besoin de la base
// ============================================================

try {
    // new PDO(DSN, user, password)
    // DSN = Data Source Name : type de base + hôte + nom de la base
    $pdo = new PDO('mysql:host=localhost;dbname=web2_auth;charset=utf8mb4', 'root', '');

    // Active les exceptions PDO : au lieu d'un warning silencieux,
    // une erreur SQL lève une exception qu'on peut attraper avec try/catch
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // En développement : affiche le message d'erreur
    // En production : log l'erreur et affiche un message générique
    die("Erreur de connexion : " . $e->getMessage());
}
