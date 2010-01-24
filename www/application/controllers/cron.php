<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cron_Controller extends Common_Controller {
	
    public function update_city_leaderboard($sekrit)
	{
        $this->auto_render = FALSE;
        if ($this->_isAGood($sekrit)) {
			#todo time me
            $leaderboard = new City_Leaderboard_Model;
            $leaderboard->recalculate();
		} else {
            echo "Permission Denied";
        }
	}
	
	public function update_user_leaderboard($leaderboard_type, $sekrit)
	{
		
        $this->auto_render = FALSE;
        if ($this->_isAGood($sekrit)) {
			if ($leaderboard_type == User_Leaderboard_Model::$pledge_type ||
				$leaderboard_type == User_Leaderboard_Model::$recruit_type) {
				#todo time me
				$leaderboard = new User_Leaderboard_Model;
				$leaderboard->recalculate($leaderboard_type);	
			} else {
				echo "Unknown Type";
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