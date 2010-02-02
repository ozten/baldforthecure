<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Keeps track of total funds raised per city
 */
class City_Leaderboard_Model extends ORM
{
    public function recalculate()
    {
        $del = "DELETE FROM city_leaderboards_loading;";
        $ins = <<<INS_SQL
              INSERT INTO city_leaderboards_loading (city, total)
  SELECT cities.name, SUM(pledges_total) FROM users
  JOIN cities ON cities.id = users.city_id
  GROUP BY city_id
  ORDER BY SUM(pledges_total) DESC;
INS_SQL;
        $mvt = <<<MV_SQL
        RENAME TABLE city_leaderboards         TO city_leaderboards_tmp,
             city_leaderboards_loading TO city_leaderboards,
             city_leaderboards_tmp     TO city_leaderboards_loading;        
MV_SQL;
        // TODO autocommit and transactions aren't working
        $this->db->query("SET AUTOCOMMIT=0");
        $this->db->query("START TRANSACTION");
        try {
            $this->db->query($del);
            $this->db->query($ins);
            $this->db->query($mvt);            
            $this->db->query("COMMIT;");
        } catch(Exception $e) {
            $this->db->query("ROLLBACK;");
            $this->db->query("SET AUTOCOMMIT=1");
        }
        

    }
}
?>