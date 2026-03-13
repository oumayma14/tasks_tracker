# 🗂 Task Manager — Projet PHP Complet

## Structure du projet

```
task_manager/
│
├── config/
│   ├── database.php       ← Connexion PDO (try/catch)
│   ├── auth.php           ← requireLogin() / requireAdmin()
│   └── base.sql           ← Créer la base de données
│
├── models/
│   ├── User.php           ← CRUD users (classe OOP)
│   └── Task.php           ← CRUD tasks (classe OOP)
│
├── controllers/
│   ├── authController.php ← Login / Logout
│   ├── taskController.php ← CRUD tâches + export CSV
│   └── userController.php ← CRUD utilisateurs (admin)
│
├── views/
│   ├── login.php          ← Formulaire de connexion
│   ├── dashboard.php      ← Tableau de bord (stats)
│   ├── layout.php         ← Sidebar partagée (include)
│   ├── footer.php         ← Fermeture HTML partagée
│   │
│   ├── admin/
│   │   ├── tasks/
│   │   │   ├── list.php   ← Toutes les tâches
│   │   │   ├── create.php ← Créer une tâche
│   │   │   └── edit.php   ← Modifier une tâche
│   │   └── users/
│   │       ├── list.php   ← Tous les utilisateurs
│   │       ├── create.php ← Créer un user
│   │       └── edit.php   ← Modifier un user
│   │
│   └── user/
│       └── mes_taches.php ← Tâches du user connecté
│
└── seed.php               ← Crée le compte admin (1 seule fois)
```

---

## Installation

1. Copie le dossier `task_manager/` dans `htdocs/` (XAMPP) ou `www/` (WAMP)
2. Ouvre phpMyAdmin et exécute `config/base.sql`
3. Visite `http://localhost/task_manager/seed.php` pour créer l'admin
4. **Supprime `seed.php`** après
5. Va sur `http://localhost/task_manager/views/login.php`
6. Connecte-toi : `admin` / `admin123`

---

## Concepts PHP utilisés (carte de révision)

| Concept              | Où dans le projet                        | Fichier de cours |
|----------------------|------------------------------------------|------------------|
| Variables & echo     | Partout                                  | 2_Variables.php  |
| if / else            | Badges couleur, redirect par rôle        | 3_conditions.php |
| switch               | Couleur statut/priorité dans les vues    | switch.php       |
| for / foreach        | Affichage des listes, stats dashboard    | 4_Boucles.php    |
| while                | fgetcsv() dans l'export                  | 5_While.php      |
| Fonctions            | requireLogin(), requireAdmin()           | function.php     |
| Formulaires POST     | Login, create, edit partout              | form.php         |
| Sessions             | $_SESSION["user"], messages d'erreur     | tp_panier.php    |
| PDO / MySQL          | Tous les modèles                         | db.php           |
| CRUD complet         | User.php, Task.php, controllers          | index.php        |
| password_hash/verify | authController, User.php                 | authController   |
| include/require      | layout.php, footer.php dans toutes vues  | layout.php       |
| Fichiers CSV         | taskController export, fopen/fputcsv     | produits.php     |
| MVC                  | Architecture globale du projet           | userController   |
| OOP (classes)        | User.php, Task.php                       | (nouveau)        |

---

## Rôles

| Rôle  | Peut faire                                              |
|-------|---------------------------------------------------------|
| admin | Tout : créer/modifier/supprimer tâches ET utilisateurs  |
| user  | Voir ses propres tâches, changer leur statut seulement  |
"# tasks_tracker" 
