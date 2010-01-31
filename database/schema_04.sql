CREATE
    TABLE users_friends
    (
        user_id SMALLINT UNSIGNED NOT NULL,
        friend_user_id SMALLINT UNSIGNED NULL,
        friend_twitter_id INT UNSIGNED NOT NULL,
        friend_username VARCHAR(80) NOT NULL,
        PRIMARY KEY  (`user_id`, friend_twitter_id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE
    TABLE pledges
    (
        id SMALLINT UNSIGNED NOT NULL,
        user_id SMALLINT UNSIGNED,
        shaver_user_id SMALLINT UNSIGNED NOT NULL,
        amount SMALLINT UNSIGNED NOT NULL,
        reason VARCHAR(140),
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE pledges MODIFY COLUMN id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE pledges ADD CONSTRAINT fk1 FOREIGN KEY (shaver_user_id) REFERENCES users (id);
ALTER TABLE pledges ADD (created TIMESTAMP DEFAULT NOW());