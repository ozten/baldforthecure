<?php defined('SYSPATH') OR die('No direct access allowed.');

class Participate_Controller extends Common_Controller {
	public function index()
	{
		$this->template->title = 'Participate in Bald for the Cure';
		$this->template->content = new View('participate/index');
		$this->template->content->title = $this->template->title;
		
		// find current user
		if (auth::logged_in()) {
			$user = ORM::factory('user')->where('id', $_SESSION['userid'])->find();
		} else {
			$user = ORM::factory('user');
		}
		$this->template->content->user = $user;
	}
	
	public function save()
	{
		$validator = new Validation($this->input->post());

		$validator->add_rules('challenge_amount', 'required', 'numeric');
		$validator->add_rules('challenge_event', 'required');
		$validator->add_rules('challenge_option', 'required', array('shave','haircut','other'));
		if ($this->input->post('challenge_option') == 'other') {
			$validator->add_rules('challenge_option_description', 'required');
		}

		if ($validator->validate()) {
			if (auth::logged_in()) {		
				$user = ORM::factory('user')->where('id', $_SESSION['userid'])->find();
				
				$user->challenge_amount = $this->input->post('challenge_amount');
				$user->challenge_event = $this->input->post('challenge_event');
				$user->challenge_option = $this->input->post('challenge_option');
				if ($this->input->post('challenge_option') == 'other') {
					$user->challenge_option_description = $this->input->post('challenge_option_description');
				}
				$user->challenge_honor = $this->input->post('challenge_honor');

				url::redirect(Kohana::config('fundraiser.pledge_url'));

			} else {
				// save to session and redirect to login
			}
		} else {
			// errors
			
			// if (! isset($_SESSION)) {		
			// 		    session_start();
			// 		}
			// 		$error_messages = array();
			// 		foreach($validator->errors() as $key => $value) {
			// 			//TODO: Create error messages http://docs.kohanaphp.com/libraries/validation
			// 			array_push($error_messages, $key . ": " . $value);
			// 		}
			// 		$_SESSION['error_messages'] = $error_messages;
			// 
			// 		url::redirect(url::site('/donate/user/' . $this->input->post('shaver_user_id')));
		}
	}
}