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
}
?>