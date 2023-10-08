<?php

// Erstellen einer SQLite-Datenbank
try {
    $db = new PDO('sqlite:' . WWW_DIR  . '/users.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents(WWW_DIR.'/sql/db-init.sql');
    // Erstellen der Benutzertabelle
    $db->exec($sql);

} catch(PDOException $e) {
    echo "Datenbankfehler: " . $e->getMessage();
}

