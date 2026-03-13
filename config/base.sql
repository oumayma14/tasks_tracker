-- ============================================================
-- Task Manager — base de données complète
-- Base: web2_auth (déjà créée dans ton projet)
-- ============================================================

CREATE DATABASE IF NOT EXISTS web2_auth;
USE web2_auth;

-- ─── TABLE USERS ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL UNIQUE,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ─── TABLE TASKS ─────────────────────────────────────────────
-- user_id = clé étrangère vers users.id
-- ON DELETE SET NULL = si le user est supprimé, la tâche reste mais user_id devient NULL
CREATE TABLE IF NOT EXISTS tasks (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titre       VARCHAR(200) NOT NULL,
    description TEXT,
    statut      ENUM('à faire','en cours','terminé') DEFAULT 'à faire',
    priorite    ENUM('basse','moyenne','haute')       DEFAULT 'moyenne',
    user_id     INT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── ADMIN PAR DÉFAUT ────────────────────────────────────────
-- mot de passe : admin123  (hashé avec PASSWORD_DEFAULT)
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@site.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- ⚠️  En prod, regénère ce hash avec password_hash('ton_mot_de_passe', PASSWORD_DEFAULT)
