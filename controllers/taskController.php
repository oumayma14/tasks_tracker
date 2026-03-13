<?php

session_start();

require_once "../config/database.php";
require_once "../config/auth.php";
require_once "../models/Task.php";
require_once "../models/User.php";

// Toutes les pages de ce contrôleur nécessitent d'être connecté
requireLogin();

// Récupère le rôle et l'ID de l'utilisateur connecté depuis la session
$role      = $_SESSION["user"]["role"];
$currentId = $_SESSION["user"]["id"];

$taskModel = new Task($pdo);
$userModel = new User($pdo);

// switch sur l'action demandée — comme switch.php du cours !
$action = $_GET["action"] ?? "list";

switch ($action) {

    // ── LIST ─────────────────────────────────────────────────
    case "list":
        if ($role === "admin") {
            // L'admin voit toutes les tâches
            $tasks = $taskModel->findAll();
            require "../views/admin/tasks/list.php";
        } else {
            // Un user normal voit seulement ses tâches
            $tasks = $taskModel->findByUser($currentId);
            require "../views/user/mes_taches.php";
        }
        break;

    // ── CREATE GET (afficher le formulaire) ──────────────────
    case "create":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            requireAdmin(); // Seul l'admin peut créer des tâches
            $users = $userModel->findAll(); // Pour le menu déroulant "Assigner à"
            require "../views/admin/tasks/create.php";

        // ── CREATE POST (traiter la création) ────────────────
        } else {
            requireAdmin();
            $titre       = trim($_POST["titre"]);
            $description = trim($_POST["description"]);
            $statut      = $_POST["statut"];
            $priorite    = $_POST["priorite"];
            $userId      = (int)$_POST["user_id"]; // cast en entier = sécurité

            $taskModel->create($titre, $description, $statut, $priorite, $userId);
            header("Location: /task_manager/controllers/taskController.php?action=list");
            exit();
        }
        break;

    // ── EDIT GET (formulaire pré-rempli) ─────────────────────
    case "edit":
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            requireAdmin();
            $task  = $taskModel->findById($_GET["id"]);
            $users = $userModel->findAll();
            if (!$task) {
                header("Location: /task_manager/controllers/taskController.php?action=list");
                exit();
            }
            require "../views/admin/tasks/edit.php";

        // ── EDIT POST (enregistrer les modifications) ─────────
        } else {
            requireAdmin();
            $id          = (int)$_POST["id"];
            $titre       = trim($_POST["titre"]);
            $description = trim($_POST["description"]);
            $statut      = $_POST["statut"];
            $priorite    = $_POST["priorite"];
            $userId      = (int)$_POST["user_id"];

            $taskModel->update($id, $titre, $description, $statut, $priorite, $userId);
            header("Location: /task_manager/controllers/taskController.php?action=list");
            exit();
        }
        break;

    // ── DELETE ───────────────────────────────────────────────
    case "delete":
        requireAdmin();
        $id = (int)$_GET["id"];
        $taskModel->delete($id);
        header("Location: /task_manager/controllers/taskController.php?action=list");
        exit();

    // ── STATUT (user simple change le statut de sa tâche) ────
    case "statut":
        // On vérifie que la requête est POST (pas un simple lien cliquable)
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id     = (int)$_POST["id"];
            $statut = $_POST["statut"];

            // updateStatut vérifie en base que la tâche appartient bien au user
            $taskModel->updateStatut($id, $statut, $currentId);
        }
        header("Location: /task_manager/controllers/taskController.php?action=list");
        exit();

    // ── EXPORT CSV ───────────────────────────────────────────
    // Génère un fichier CSV téléchargeable avec toutes les tâches
    // Utilise fopen/fputcsv comme dans produits.php du cours
    case "export":
        requireAdmin();
        $tasks = $taskModel->exportAll();

        // Ces headers disent au navigateur "c'est un fichier à télécharger"
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=taches_export.csv");

        // php://output = flux de sortie direct (le navigateur le reçoit comme fichier)
        $fichier = fopen("php://output", "w");

        // Première ligne = en-têtes des colonnes
        fputcsv($fichier, ["ID", "Titre", "Description", "Statut", "Priorité", "Assigné à", "Créé le"]);

        // Boucle foreach comme dans le cours pour écrire chaque ligne
        foreach ($tasks as $task) {
            fputcsv($fichier, [
                $task["id"],
                $task["titre"],
                $task["description"],
                $task["statut"],
                $task["priorite"],
                $task["username"] ?? "Non assigné",
                $task["created_at"]
            ]);
        }
        fclose($fichier);
        exit();
}
