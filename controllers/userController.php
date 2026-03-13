<?php


session_start();

require_once "../config/database.php";
require_once "../config/auth.php";
require_once "../models/User.php";

requireAdmin(); // Toutes les routes ici = admin seulement

$userModel = new User($pdo);
$action    = $_GET["action"] ?? "list";

switch ($action) {

    // ── LIST ─────────────────────────────────────────────────
    case "list":
        $users = $userModel->findAll();
        require "../views/admin/users/list.php";
        break;

    // ── CREATE ───────────────────────────────────────────────
    case "create":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            require "../views/admin/users/create.php";
        } else {
            $username = trim($_POST["username"]);
            $email    = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $role     = $_POST["role"] ?? "user";

            $userModel->create($username, $email, $password, $role);
            header("Location: /task_manager/controllers/userController.php?action=list");
            exit();
        }
        break;

    // ── EDIT ─────────────────────────────────────────────────
    case "edit":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $user = $userModel->findById($_GET["id"]);
            if (!$user) {
                header("Location: /task_manager/controllers/userController.php?action=list");
                exit();
            }
            require "../views/admin/users/edit.php";
        } else {
            $id       = (int)$_POST["id"];
            $username = trim($_POST["username"]);
            $email    = trim($_POST["email"]);
            $role     = $_POST["role"] ?? "user";
            // Si le champ password est vide → null → le modèle ne le change pas
            $password = !empty($_POST["password"]) ? trim($_POST["password"]) : null;

            $userModel->update($id, $username, $email, $role, $password);
            header("Location: /task_manager/controllers/userController.php?action=list");
            exit();
        }
        break;

    // ── DELETE ───────────────────────────────────────────────
    case "delete":
        $id = (int)$_GET["id"];
        $userModel->delete($id);
        header("Location: /task_manager/controllers/userController.php?action=list");
        exit();
}
