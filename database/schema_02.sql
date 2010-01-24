DROP TABLE IF EXISTS `city_leaderboards_loading`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_leaderboards_loading` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `city` varchar(255) NOT NULL,
  `rank` tinyint(3) unsigned NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;



ALTER TABLE city_leaderboards DROP COLUMN rank;
ALTER TABLE city_leaderboards_loading DROP COLUMN rank;

DROP TABLE IF EXISTS `user_leaderboards_loading`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_leaderboards_loading` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned NOT NULL,
  `type` char(4) NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id_loading_fk` (`user_id`),
  CONSTRAINT `user_id_loading_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

ALTER TABLE
    user_leaderboards DROP COLUMN rank;
    
ALTER TABLE
    user_leaderboards ADD (city_id SMALLINT UNSIGNED NOT NULL);
ALTER TABLE
    user_leaderboards_loading ADD (city_id SMALLINT UNSIGNED NOT NULL);
    
RENAME TABLE user_leaderboards TO user_pledge_leaderboards,
             user_leaderboards_loading TO user_pledge_leaderboards_loading;

ALTER TABLE
    user_pledge_leaderboards DROP COLUMN `type`;
ALTER TABLE
    user_pledge_leaderboards_loading DROP COLUMN `type`;
    
CREATE
    TABLE user_recruit_leaderboards
    (
        id SMALLINT(5) unsigned NOT NULL AUTO_INCREMENT,
        user_id SMALLINT(5) unsigned NOT NULL,
        total SMALLINT(5) unsigned NOT NULL,
        city_id SMALLINT(5) unsigned NOT NULL,
        PRIMARY KEY USING BTREE (id),
        CONSTRAINT user_recruit_id_fk FOREIGN KEY (user_id) REFERENCES users (id),
        INDEX user_id_fk USING BTREE (user_id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE
    TABLE user_recruit_leaderboards_loading
    (
        id SMALLINT(5) unsigned NOT NULL AUTO_INCREMENT,
        user_id SMALLINT(5) unsigned NOT NULL,
        total SMALLINT(5) unsigned NOT NULL,
        city_id SMALLINT(5) unsigned NOT NULL,
        PRIMARY KEY USING BTREE (id),
        CONSTRAINT user_recruit_load_id_fk FOREIGN KEY (user_id) REFERENCES users (id),
        INDEX user_id_fk USING BTREE (user_id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    
CREATE
    TABLE recruits
    (
        recruiter SMALLINT UNSIGNED NOT NULL,
        recruitee SMALLINT UNSIGNED NOT NULL,
        PRIMARY KEY (recruiter, recruitee)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE
    recruits ADD CONSTRAINT recruits_recruitee_fk FOREIGN KEY (recruitee) REFERENCES users (id);
ALTER TABLE
    recruits ADD CONSTRAINT recruits_recruiter_fk FOREIGN KEY (recruiter) REFERENCES users (id);