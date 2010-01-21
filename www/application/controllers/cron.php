<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cron_Controller extends Common_Controller {
	
    public function update_city_leaderboard($sekrit)
	{
        $this->auto_render = FALSE;
        if ($this->_isAGood($sekrit)) {
            $user = new User_Model;
            foreach($user->cities() as $city) {
                echo Kohana::debug($city);
            }
		} else {
            echo "Permission Denied";
        }
	}
    
    private function _isAGood($sekrit)
    {
        return $sekrit == Kohana::config('cron.sekrit');
    }
}
?>