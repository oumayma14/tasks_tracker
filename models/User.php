<?php
// ============================================================
// models/User.php — Modèle User (toutes les requêtes SQL liées aux users)
// C'est le "M" dans MVC : il parle à la base, rien d'autre
// ============================================================

class User {

    // $pdo est private : seule cette classe peut l'utiliser
    private $pdo;

    // __construct est appelé automatiquement quand on fait new User($pdo)
    // On reçoit la connexion PDO et on la stocke dans l'objet
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ── CREATE ──────────────────────────────────────────────
    // Crée un nouvel utilisateur avec un mot de passe hashé
    public function create($username, $email, $password, $role = "user") {
        // password_hash() transforme "1234" en "$2y$10$xxx..." (irréversible)
        // PASSWORD_DEFAULT = algorithme bcrypt recommandé
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // prepare() = requête paramétrée → protège contre les injections SQL
        // Les ? sont remplacés par les valeurs dans execute()
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$username, $email, $hash, $role]);
    }

    // ── READ ALL ─────────────────────────────────────────────
    // Retourne tous les utilisateurs (pour l'admin)
    public function findAll() {
        $stmt = $this->pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
        // fetchAll retourne un tableau de tableaux associatifs
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ── READ ONE by ID ───────────────────────────────────────
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        // fetch() retourne une seule ligne (ou false si introuvable)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ── READ ONE by USERNAME ─────────────────────────────────
    // Utilisé lors de la connexion pour retrouver l'utilisateur
    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ── UPDATE ───────────────────────────────────────────────
    // Si $password est null → on ne change pas le mot de passe
    // Si $password est fourni → on le hashe et on l'inclut dans l'UPDATE
    public function update($id, $username, $email, $role, $password = null) {
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare(
                "UPDATE users SET username=?, email=?, role=?, password=? WHERE id=?"
            );
            return $stmt->execute([$username, $email, $role, $hash, $id]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE users SET username=?, email=?, role=? WHERE id=?"
            );
            return $stmt->execute([$username, $email, $role, $id]);
        }
    }

    // ── DELETE ───────────────────────────────────────────────
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }

    // ── COUNT ────────────────────────────────────────────────
    // Compte le nombre total d'utilisateurs (pour le dashboard admin)
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
