<?php defined('SYSPATH') OR die('No direct access allowed.');
class User_Model extends ORM
{
    protected $has_many = array('photos');
    public function cities()
    {
        return $this->db->query("SELECT cities.canonical_city_name, SUM(users.pledges_total) as total FROM users
                                 JOIN cities ON users.city_id = cities.id
                                 GROUP BY cities.id
                                 ORDER BY total
                                 LIMIT 10
                                ");
    }
    /*** update area support ***/
    public function username()
    {
        return $this->username;
    }
    public function action()
    {
        return "joined";
    }
    public function show()
    {
        return "<a href='" . url::site('/profile/index/' . $this->username) . "'><img src='" . $this->avatar . "' width='48' height='48' /></a>";
    }
    
    /**
     * Given a list of twitter ids, returns user objects
     * for users that already exist
     */
    public function get_users_by_twitter_ids($ids)
    {
        return $this->in('twitter_id', $ids)->find_all();
    }
    
    public function repairPledgesTotal()
    {
        $this->db->query("UPDATE users SET pledges_total =
                             (SELECT SUM(amount) FROM pledges WHERE shaver_user_id = ?)
                          WHERE id = ?",
                         array($this->id, $this->id));
    }
    public function totalAllPledges()
    {
        return $this->db->query("SELECT SUM(pledges_total) as total FROM users")->current()->total;
    }
}
?>