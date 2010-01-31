<?php defined('SYSPATH') OR die('No direct access allowed.');

class Donate_Controller extends Common_Controller {

	public function user($shaver_user_id)
	{
		
		$shaver = ORM::factory('user')->where('id', $shaver_user_id)->find();
		$this->template->title = "Donate to {$shaver->username} during Bald for a Cure";
		$this->template->content = new View('donate/user');
		$this->template->content->page_target = '_blank';
		
		$this->template->set_global('donate_shaver_user_id', $shaver->id);
		$this->template->content->shaver_user_id = $shaver_user_id;
		
		$ip = $this->input->ip_address();
		
		$this->template->content->ip = $ip;
		$this->template->content->nonce = md5($shaver_user_id . Kohana::config('nonce.salt') . $ip);
		
		if (isset($_SESSION) &&
			array_key_exists('error_messages', $_SESSION)) {
			    $this->template->error_messages = $_SESSION['error_messages'];
				$this->template->content->page_target = '_self';
				unset($_SESSION['error_messages']);
		}
		
	}
	public function pledge()
	{
		$this->auto_render = FALSE;
		// Process pledge
		
		$validator = new Validation($this->input->post());
		$validator->add_rules('shaver_user_id', 'required', 'numeric');
		#TODO check shaver_user_id is a valid user id
		$validator->add_rules('pledge_amount', 'required', 'numeric');		
		$validator->add_rules('nonce', 'required');
		if ($this->input->post('nonce')) {
			$nonce = $this->input->post('nonce');
			$ip = $this->input->ip_address();
			if ($nonce != md5($this->input->post('shaver_user_id') . Kohana::config('nonce.salt') . $ip)) {				
				$validator->add_error('nonce', 'nonce_check');
			}
		}
		if ($validator->validate()) {
			$pledge = ORM::factory('pledge');
			
			$data = $validator->as_array();
			
			$donor_id = -1;
			if (isset($_SESSION) &&
			    array_key_exists('userid', $_SESSION)) {
				$donor_id = $_SESSION['userid'];
			}			
			if ($donor_id > 0) {
				$pledge->user_id = $donor_id;	
			}
			
			
			if (-1 == $data['shaver_user_id']) {
				$pledge->shaver_user_id = 1; //TODO Do we allow generic donations? Where should we store them?
			} else {
				$pledge->shaver_user_id = $data['shaver_user_id'];
			}
			$pledge->amount = $data['pledge_amount'];
			if (array_key_exists('pledge_reason', $data) &&
				trim($data['pledge_reason'] != '')) {
				$pledge->reason = $data['pledge_reason'];
			}
			
			Kohana::log('info', "Saving pledge {$pledge->amount} for {$pledge->shaver_user_id}");
			if ($pledge->save()) {
				$shaver = ORM::factory('user')->where('id', $pledge->shaver_user_id)->find();
				$shaver->repairPledgesTotal();
			} else {
				Kohana::log('alert', "Saving pledge failed for unknown reason", Kohana::debug($data));
			}
			
			url::redirect(Kohana::config('fundraiser.pledge_url'));
			
		} else {
			if (! isset($_SESSION)) {		
			    session_start();
			}
			$error_messages = array();
			foreach($validator->errors() as $key => $value) {
				//TODO: Create error messages http://docs.kohanaphp.com/libraries/validation
				array_push($error_messages, $key . ": " . $value);
			}
			$_SESSION['error_messages'] = $error_messages;
			
			url::redirect(url::site('/donate/user/' . $this->input->post('shaver_user_id')));
		}
		
	}
}