# Task Tracker

A role-based task management web application built with PHP, MySQL, and Bootstrap. Developed as part of a web development course to practice full-stack PHP concepts including MVC architecture, authentication, sessions, and database management.

## Tech Stack

- **Backend:** PHP 8.2
- **Database:** MySQL (PDO)
- **Frontend:** Bootstrap 5, Bootstrap Icons
- **Architecture:** MVC (Model - View - Controller)
- **Server:** Apache (XAMPP)


## Installation

1. Clone the repository into your htdocs folder

git clone https://github.com/oumayma14/tasks_tracker.git

2. Open phpMyAdmin and run config/base.sql to create the database

3. Visit http://localhost/task_manager/seed.php to create the default admin account

4. Delete seed.php after running it

5. Go to http://localhost/task_manager/views/login.php

## Default Credentials

| Role  | Username | Password |
|-------|----------|----------|
| Admin | admin    | password |

Change the password after first login.

## Roles

| Role  | Permissions |
|-------|-------------|
| Admin | Create, edit, delete tasks and users. Export CSV. View all tasks. |
| User  | View assigned tasks. Update task status only. |
