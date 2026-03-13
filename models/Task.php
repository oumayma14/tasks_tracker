<?php
// ============================================================
// models/Task.php — Modèle Task (toutes les requêtes SQL liées aux tâches)
// ============================================================

class Task {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ── READ ALL (admin) ─────────────────────────────────────
    // Retourne toutes les tâches avec le nom du user assigné
    // JOIN = on relie la table tasks à users pour avoir le username
    public function findAll() {
        $stmt = $this->pdo->query(
            "SELECT tasks.*, users.username
             FROM tasks
             LEFT JOIN users ON tasks.user_id = users.id
             ORDER BY tasks.created_at DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ── READ by USER ─────────────────────────────────────────
    // Retourne uniquement les tâches d'un utilisateur spécifique
    public function findByUser($userId) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ── READ ONE ─────────────────────────────────────────────
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ── CREATE ───────────────────────────────────────────────
    public function create($titre, $description, $statut, $priorite, $userId) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO tasks (titre, description, statut, priorite, user_id)
             VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$titre, $description, $statut, $priorite, $userId]);
    }

    // ── UPDATE COMPLET (admin) ────────────────────────────────
    // Modifie tous les champs d'une tâche
    public function update($id, $titre, $description, $statut, $priorite, $userId) {
        $stmt = $this->pdo->prepare(
            "UPDATE tasks SET titre=?, description=?, statut=?, priorite=?, user_id=?
             WHERE id=?"
        );
        return $stmt->execute([$titre, $description, $statut, $priorite, $userId, $id]);
    }

    // ── UPDATE STATUT SEULEMENT (user simple) ────────────────
    // Un user normal peut seulement changer le statut de SA tâche
    // On vérifie aussi que user_id correspond pour sécurité
    public function updateStatut($id, $statut, $userId) {
        $stmt = $this->pdo->prepare(
            "UPDATE tasks SET statut=? WHERE id=? AND user_id=?"
        );
        return $stmt->execute([$statut, $id, $userId]);
    }

    // ── DELETE ───────────────────────────────────────────────
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id=?");
        return $stmt->execute([$id]);
    }

    // ── COUNT ALL ────────────────────────────────────────────
    // Nombre total de tâches (pour le dashboard admin)
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
    }

    // ── COUNT by STATUT ──────────────────────────────────────
    // Combien de tâches sont "terminé", "en cours", etc.
    public function countByStatut($statut) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tasks WHERE statut=?");
        $stmt->execute([$statut]);
        return $stmt->fetchColumn();
    }

    // ── COUNT by USER ─────────────────────────────────────────
    public function countByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id=?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    // ── EXPORT CSV ───────────────────────────────────────────
    // Retourne toutes les tâches sous forme de tableau simple
    // pour les écrire dans un fichier CSV (comme dans produits.php)
    public function exportAll() {
        $stmt = $this->pdo->query(
            "SELECT tasks.id, tasks.titre, tasks.description, tasks.statut,
                    tasks.priorite, users.username, tasks.created_at
             FROM tasks
             LEFT JOIN users ON tasks.user_id = users.id
             ORDER BY tasks.id ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
