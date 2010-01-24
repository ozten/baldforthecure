<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Keeps track of two types of activities
 * pledge - People with the highest number of pledges
 * recruit - People who have recruited the most other users
 *
 * This class inherits Model instead of ORM because the class name
 * doesn't match the table name and we don't use ORM anywhoos.
 */
class User_Leaderboard_Model extends Model
{
    public static $pledge_type  = 'pledge';
    public static $recruit_type = 'recruit';
    
    public function recalculate($leaderboard_type)
    {
        echo "starting";
        $del = "DELETE FROM user_${leaderboard_type}_leaderboards_loading";
        if (self::$pledge_type == $leaderboard_type) {
            $ins = <<<INS_PLDG_SQL
INSERT INTO user_${leaderboard_type}_leaderboards_loading (user_id, total, city_id)
  SELECT users.id, SUM(pledges_total), city_id FROM users
  GROUP BY city_id, users.id
  ORDER BY city_id, SUM(pledges_total) DESC;
INS_PLDG_SQL;
        } else {
            $ins = <<<INS_RCRT_SQL
INSERT INTO user_${leaderboard_type}_leaderboards_loading (user_id, total, city_id)
  SELECT users.id, COUNT(recruits.recruiter), users.city_id FROM users
  JOIN recruits ON recruits.recruiter = users.id
  GROUP BY city_id, users.id
  ORDER BY city_id, COUNT(recruits.recruiter) DESC;
INS_RCRT_SQL;
        }    
        $mvt = <<<MV_SQL
RENAME TABLE user_${leaderboard_type}_leaderboards         TO user_${leaderboard_type}_leaderboards_tmp,
             user_${leaderboard_type}_leaderboards_loading TO user_${leaderboard_type}_leaderboards,
             user_${leaderboard_type}_leaderboards_tmp     TO user_${leaderboard_type}_leaderboards_loading;        
MV_SQL;
        // TODO autocommit and transactions aren't working
        $this->db->query("SET AUTOCOMMIT=0");
        $this->db->query("START TRANSACTION");
        #try {
            $this->db->query($del, array($leaderboard_type));
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