-- D1 (SQLite) version of the dopewars metaserver schema.
-- Column names keep their original MySQL capitalization; SQLite returns them as declared.
-- Timestamps are stored as UTC text 'YYYY-MM-DD HH:MM:SS' (what datetime('now') produces),
-- which sorts and compares correctly as plain strings.

CREATE TABLE dynamicdns (
  Password  TEXT NOT NULL PRIMARY KEY,   -- SQLite '=' is case-sensitive, like latin1_bin
  ServerID  INTEGER
);

CREATE TABLE highscores (
  Name      TEXT,
  Date      TEXT,
  Status    TEXT CHECK (Status IN ('dead', 'alive')),
  Score     TEXT,
  ServerID  INTEGER NOT NULL DEFAULT 0,
  ID        INTEGER NOT NULL DEFAULT 0,
  -- ServerID first, so this key also serves lookups and deletes by ServerID
  PRIMARY KEY (ServerID, ID)
);

CREATE TABLE hostoverride (
  Password  TEXT NOT NULL PRIMARY KEY,
  HostName  TEXT COLLATE NOCASE          -- MySQL's default collation compared hostnames case-insensitively
);

CREATE TABLE localdns (
  IP        TEXT NOT NULL PRIMARY KEY,
  HostName  TEXT
);

CREATE TABLE servers (
  ID          INTEGER PRIMARY KEY AUTOINCREMENT,  -- never reuses IDs, like MySQL AUTO_INCREMENT
  Version     TEXT,
  Players     INTEGER,
  MaxPlayers  INTEGER,
  LastUpdate  TEXT NOT NULL DEFAULT (datetime('now')),
  UpSince     TEXT,
  HostName    TEXT NOT NULL COLLATE NOCASE,
  Comment     TEXT,
  IP          TEXT,
  Port        INTEGER NOT NULL DEFAULT 0,
  ProxyIP     TEXT,
  Credential  TEXT
);
