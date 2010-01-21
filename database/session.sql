-- I think we'll stay with Cookie based sessions... but if we need DB sessions here is the schema

CREATE TABLE sessions
(
    session_id VARCHAR(127) NOT NULL,
    last_activity INT(10) UNSIGNED NOT NULL,
    DATA TEXT NOT NULL,
    PRIMARY KEY (session_id)
);