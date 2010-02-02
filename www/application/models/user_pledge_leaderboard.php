<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Keeps track of two types of activities
 * pledge - People with the highest number of pledges
 * recruit - People who have recruited the most other users
 *
 */
class User_Pledge_Leaderboard_Model extends ORM
{
    public static $leader_type  = 'pledge';
    
    public function recalculate()
    {
        echo "starting";
        $del = "DELETE FROM user_pledge_leaderboards_loading";
            $ins = <<<INS_PLDG_SQL
INSERT INTO user_pledge_leaderboards_loading (user_id, username, name, total, city_id)
  SELECT users.id, users.username, users.name, SUM(pledges_total), city_id FROM users
  GROUP BY city_id, users.id, users.username, users.name
  ORDER BY city_id, SUM(pledges_total) DESC;
INS_PLDG_SQL;
        $mvt = <<<MV_SQL
RENAME TABLE user_pledge_leaderboards         TO user_pledge_leaderboards_tmp,
             user_pledge_leaderboards_loading TO user_pledge_leaderboards,
             user_pledge_leaderboards_tmp     TO user_pledge_leaderboards_loading;        
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