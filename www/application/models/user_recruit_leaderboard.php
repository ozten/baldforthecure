<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Keeps track of two types of activities
 * pledge - People with the highest number of pledges
 * recruit - People who have recruited the most other users
 *
 * This class inherits Model instead of ORM because the class name
 * doesn't match the table name and we don't use ORM anywhoos.
 */
class User_Recruit_Leaderboard_Model extends ORM
{
    public static $leader_type = 'recruit';
    
    public function recalculate()
    {
        echo "starting";
        $del = "DELETE FROM user_recruit_leaderboards_loading";        
            $ins = <<<INS_RCRT_SQL
INSERT INTO user_recruit_leaderboards_loading (user_id, username, name, total, city_id)
  SELECT users.id, users.username, users.name, COUNT(recruits.recruiter), users.city_id FROM users
  JOIN recruits ON recruits.recruiter = users.id
  GROUP BY city_id, users.id, users.username, users.name
  ORDER BY city_id, COUNT(recruits.recruiter) DESC;
INS_RCRT_SQL;
        
        $mvt = <<<MV_SQL
RENAME TABLE user_recruit_leaderboards         TO user_recruit_leaderboards_tmp,
             user_recruit_leaderboards_loading TO user_recruit_leaderboards,
             user_recruit_leaderboards_tmp     TO user_recruit_leaderboards_loading;        
MV_SQL;
        // TODO autocommit and transactions aren't working
        $this->db->query("SET AUTOCOMMIT=0");
        $this->db->query("START TRANSACTION");
        #try {
            $this->db->query($del);
            $this->db->query($ins);
            $this->db->query($mvt);            
            $this->db->query("COMMIT;");
        /*} catch(Exception $e) {
            $this->db->query("ROLLBACK;");
            $this->db->query("SET AUTOCOMMIT=1");
        }*/
        echo "done";

    }
}
?>