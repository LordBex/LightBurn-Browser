<?php

// Erstellen einer SQLite-Datenbank
try {
    $db = new PDO('sqlite:' . WWW_DIR  . '/users.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Erstellen der Benutzertabelle
    $db->exec("CREATE TABLE IF NOT EXISTS users (
               id INTEGER PRIMARY KEY AUTOINCREMENT,
               username TEXT UNIQUE NOT NULL,
               password TEXT NOT NULL,
               role TEXT NOT NULL);");

} catch(PDOException $e) {
    echo "Datenbankfehler: " . $e->getMessage();
}

