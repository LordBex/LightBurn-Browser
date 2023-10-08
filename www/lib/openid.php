<?php


use Jumbojett\OpenIDConnectClient;

session_start();
require_once (WWW_DIR.'lib/db.php');

class OpenID{

    private $db;
    public $oidc;
    public string $name;

    public function __construct(string $name, string $url, string $client_id, string $secret) {
        global $db;
        $this->db = $db;
        $this->name = $name;
        $this->oidc = new OpenIDConnectClient(
            $url, // SSO-Server URL
            $client_id, // Client ID
            $secret // Client Secret
        );
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
}