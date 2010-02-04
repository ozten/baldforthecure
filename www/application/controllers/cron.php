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
			if ($leaderboard_type == User_Pledge_Leaderboard_Model::$leader_type) {
				$leaderboard = new User_Pledge_Leaderboard_Model;
			} else if($leaderboard_type == User_Recruit_Leaderboard_Model::$leader_type) {								
				#todo time me
				$leaderboard = new User_Pledge_Leaderboard_Model;
			} else {
				echo "Unknown Type";
				return;
			}
			$leaderboard->recalculate();
		} else {
            echo "Permission Denied";
        }
	}
	
	public function update_sponsors($sekrit)
	{
		$this->auto_render = FALSE;
        if ($this->_isAGood($sekrit)) {
			$flickr = flickr::makeFlickr();
			$photos = $flickr->photos_search(array(
				'user_id' => flickr::userId(),
				'tags' => 'sponsor',
			));
			
			foreach($photos['photo'] as $photo) {
				
				try {					
					$info = $flickr->photos_getInfo($photo['id']);
				
					$sizes = $flickr->photos_getSizes($photo['id']);
					
					$sponsor = ORM::factory('sponsor');
					$sponsor->flickr_id = $photo['id'];
					$sponsor->name = $photo['title'];					
					# This is raw HTML which should contain a link back to the site
					$sponsor->url = $info['description'];
					if ($sizes) {
						foreach($sizes as $size) {
							/**
							 * We record Large (usually this is the full size icon
							 * or Original) since photo is smaller than 500 pixels
							 */
							if ('Large' == $size['label'] ||
								'Original' == $size['label']) {
								$sponsor->imagesrc = $size['source'];
								
								
								$sponsor->width = $size['width'];
								$sponsor->height = $size['height'];		
								break;
							}
						}
					} else {
						Kohana::log('alert', "No results for photos_getSizes");
					}
					$sponsor->save();					
				} catch (Exception $e) {
					Kohana::log('info', "Caught an exception, coudn't import Flickr image " . $photo['id'] .
								' ' . $photo['title'] . ' reason: ' . $e);					
				}
				usleep(300);				
				$icon = APPPATH . '../i/' . $photo['id'] . '.jpg';
				
				if (file_exists($icon)) {
					Kohana::log('debug', "Skipping $icon already exists");
				} else {
					copy($size['source'], $icon);	
				}
			} 
		} else {
			# no access
		}
	}
    
    private function _isAGood($sekrit)
    {
        return $sekrit == Kohana::config('cron.sekrit');
    }
}
?>