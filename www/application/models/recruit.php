<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Useful for random db interactions
 */
class Recruit_Model extends Model
{
    public function saveRecruit($recruiter_screenname, $recruitee_id)
    {
        $this->db->query("INSERT INTO recruits (recruiter, recruitee) VALUES
							  ((SELECT id FROM users WHERE username = ?), ?);",
							  array($recruiter_screenname, $recruitee_id));
    }
}
?>