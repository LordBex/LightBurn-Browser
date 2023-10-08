CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,  -- eindeutige ID für jeden Benutzer, automatisch erhöht
    username TEXT UNIQUE NOT NULL,  -- der eindeutige Benutzername, darf nicht NULL sein
    password TEXT,  -- Passwort des Benutzers, könnte NULL für OIDC-Benutzer sein
    role TEXT NOT NULL,  -- Rolle des Benutzers im System, darf nicht NULL sein
    oidc_id TEXT UNIQUE,  -- eindeutige ID (sub claim) aus OpenID Connect
    email TEXT  -- E-Mail (email claim) aus OpenID Connect
);