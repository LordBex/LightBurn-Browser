<?php

session_start();
require_once (WWW_DIR.'lib/db.php');

class UserClass {

    private PDO $db;
    private mixed $currentUserId;

    public function __construct() {
        global $db;
        $this->db = $db;
        $this->currentUserId = $_SESSION['currentUserId'] ?? null;
    }

    public function login($username, $password): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['password'])) {

            if (!password_verify($password, $user['password'])){
                return false;
            }

            $_SESSION['currentUser'] = $username;
            $_SESSION['currentUserId'] = $user['id'];  // Speichern der user_id in der Session
            $this->currentUserId = $user['id'];
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['currentUser']);
        unset($_SESSION['currentUserId']);  // Entfernen der user_id aus der Session
        $this->currentUserId = null;
    }

    public function register($username, $password, $role = 'user'): bool
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function isLogged(): bool
    {
        return isset($_SESSION['currentUser']);
    }

    public function isAdmin(): bool
    {
        if (!$this->isLogged()) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $this->currentUserId);
        $stmt->execute();

        $role = $stmt->fetchColumn();

        return $role === 'admin';
    }

    public function getCurrentUser()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $this->currentUserId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}


