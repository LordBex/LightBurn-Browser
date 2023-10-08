<?php

use Jumbojett\OpenIDConnectClient;

session_start();
require_once (WWW_DIR.'lib/db.php');

class UserClass {

    private $db;
    public $oidc;
    private $currentUserId;

    public function __construct() {
        global $db;
        $this->db = $db;
        $this->oidc = new OpenIDConnectClient(
            OPENID_URL, // SSO-Server URL
            OPENID_CLIENT_ID, // Client ID
            OPENID_SECRET // Client Secret
        );
        // $this->oidc->setRedirectURL(OPENID_CALLBACK_URL);
        $this->currentUserId = $_SESSION['currentUserId'] ?? null;
    }

    public function login($username, $password) {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['currentUser'] = $username;
            $_SESSION['currentUserId'] = $user['id'];  // Speichern der user_id in der Session
            $this->currentUserId = $user['id'];
            return true;
        }
        return false;
    }

    public function logout() {
        unset($_SESSION['currentUser']);
        unset($_SESSION['currentUserId']);  // Entfernen der user_id aus der Session
        $this->currentUserId = null;
    }

    public function register($username, $password, $role = 'user') {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function registerOpenId($userinfo = null) {
        if ($userinfo == null){
            if (!$this->oidc->authenticate()) {
                throw new Exception('Fehler bei der Authentifizierung.');
            }

            $userinfo = $this->oidc->requestUserInfo();
        }

        $stmt = $this->db->prepare("INSERT INTO users (username, oidc_id, email, role) VALUES (:username, :oidc_id, :email, :role)");
        $stmt->bindParam(':username', $userinfo->username);
        $stmt->bindParam(':oidc_id', $userinfo->sub);
        $stmt->bindParam(':email', $userinfo->email);
        $stmt->bindValue(':role', 'user');  // role wird als 'user' gesetzt, kann angepasst werden

        if (!$stmt->execute()) {
            throw new Exception('Fehler beim Registrieren des OIDC-Benutzers.');
        }

        $_SESSION['currentUser'] = $userinfo->username;
        $_SESSION['currentUserId'] = $this->db->lastInsertId();
        $this->currentUserId = $this->db->lastInsertId();

        return true;
    }

    public function loginOpenId() {
        if (!$this->oidc->authenticate()) {
            throw new Exception('Fehler bei der Authentifizierung.');
        }

        $userinfo = $this->oidc->requestUserInfo();

        $stmt = $this->db->prepare("SELECT * FROM users WHERE oidc_id = :oidc_id");
        $stmt->bindParam(':oidc_id', $userinfo->sub);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Wenn der Benutzer nicht existiert, erstellen wir ihn.
        if (!$user) {
            return $this->registerOpenId($userinfo);
        } else {
            $newUserId = $user['id'];
        }

        $_SESSION['currentUser'] = $userinfo->username;
        $_SESSION['currentUserId'] = $newUserId;
        $this->currentUserId = $newUserId;

        return true;
    }

    public function isLogged() {
        return isset($_SESSION['currentUser']);
    }

    public function isAdmin() {
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


