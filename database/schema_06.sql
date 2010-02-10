ALTER TABLE users ADD (challenge_amount INT NOT NULL);
ALTER TABLE users ADD (challenge_event VARCHAR(255) NOT NULL);
ALTER TABLE users ADD (challenge_option VARCHAR(80) NOT NULL);
ALTER TABLE users ADD (challenge_option_description VARCHAR(255) NOT NULL);
ALTER TABLE users ADD (challenge_honor VARCHAR(255) NOT NULL);