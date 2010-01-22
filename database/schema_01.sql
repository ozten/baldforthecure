ALTER TABLE users ADD (created TIMESTAMP);
UPDATE users SET created = NOW();