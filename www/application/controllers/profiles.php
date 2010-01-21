<?php defined('SYSPATH') OR die('No direct access allowed.');

class Profiles_Controller extends Common_Controller {
	
    public function browse()
	{
		$users = ORM::factory('user')->find_all();
		$this->template->title = "Browse Bald for the Cure users";
		$this->template->content = new View('profiles/browse');
		$this->template->content->users = $users;
		
	}
	
}
?>