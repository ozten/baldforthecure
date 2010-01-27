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
}
?>