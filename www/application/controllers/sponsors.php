<?php defined('SYSPATH') OR die('No direct access allowed.');

class Sponsors_Controller extends Common_Controller {

	public function index()
	{
		$this->template->title = "Offical Sponsors of the Bald for the Cure Event";
		$this->template->content = new View('sponsors/index');
        $this->template->content->sponsors = ORM::factory('sponsor')->find_all();
		
		
		if (isset($_SESSION) &&
			array_key_exists('error_messages', $_SESSION)) {
			    $this->template->error_messages = $_SESSION['error_messages'];
				$this->template->content->page_target = '_self';
				unset($_SESSION['error_messages']);
		}		
	}
}