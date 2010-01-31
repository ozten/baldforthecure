<?php
class Users_Friend_Model extends ORM
{
    public function add_new_friends($user_id, $twitter_ids)
    {
        if (count($twitter_ids) > 0) {
            $insert = "INSERT INTO users_friends (user_id, friend_twitter_id) VALUES ";
            $data = array();
            foreach($twitter_ids as $twitter_id) {
                array_push($data, "(" . $user_id . "," . $this->db->escape($twitter_id) . ")");
            }
            $insert .= implode(', ', $data);            
        }
    }
    
    public function get_old_friends($user_id)
    {
        return $this->db->query("SELECT friend_twitter_id FROM users_friends WHERE user_id = ? ", $user_id)->result();
    }
}
?>