ALTER TABLE user_pledge_leaderboards ADD (username VARCHAR(80) NOT NULL);
ALTER TABLE user_pledge_leaderboards ADD (name VARCHAR(80) NOT NULL);
ALTER TABLE user_pledge_leaderboards_loading ADD (username VARCHAR(80) NOT NULL);
ALTER TABLE user_pledge_leaderboards_loading ADD (name VARCHAR(80) NOT NULL);

ALTER TABLE user_recruit_leaderboards ADD (username VARCHAR(80) NOT NULL);
ALTER TABLE user_recruit_leaderboards ADD (name VARCHAR(80) NOT NULL);
ALTER TABLE user_recruit_leaderboards_loading ADD (username VARCHAR(80) NOT NULL);
ALTER TABLE user_recruit_leaderboards_loading ADD (name VARCHAR(80) NOT NULL);
