<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));

/**
 *
 */
class Recruit_Controller extends Common_Controller {
	public function index()
	{
		if (auth::logged_in()) {
			$this->template->title = "Recruit Your Friends for Bald for the Cure";
		    $this->template->content = new View('recruit/index');
			$this->template->content->title = "Recruit Your Friends, Update Your Status";
			$recruit_url = url::site("/recruit/by/" . $_SESSION['username']);
			$this->template->content->recruit_url = bitly::shorten($recruit_url);
		} else {
			$this->template->title = "Login Required";
			$this->template->content = new View('recruit/login_required');
		}
	}
	public function tweet($msg)
	{
		$this->auto_render = FALSE;
		//content-type json
		if (auth::logged_in()) {
			$connection = twitt::er();
			
			#'Firefox 3.6 is ready to bounce tommorrow. It\'s like Christmas in July in January. #Firefox'
			
			$resp = $connection->post('statuses/update',
									  array('status' => $msg));
			echo json_encode($resp);
		} else {
			echo json_encode(array('error' => 'Error: Not logged in'));
		}
	}
	public function by($username)
	{
		if (! isset($_SESSION)) {
		    session_start();
		}
		# Setup who recruited us for credit after account creation
		$_SESSION['recruiter'] = $username;
		url::redirect(url::site('/oauth/login'));
	}
	public function friend()
	{
		$this->auto_render = FALSE;
		if (! isset($_SESSION)) {
		    session_start();	
		}
		if (array_key_exists('access_token', $_SESSION)) {
			$connection = twitt::er();
			
			$status = 'Test';
			#'Firefox 3.6 is ready to bounce tommorrow. It\'s like Christmas in July in January. #Firefox'
			
			$resp = $connection->post('statuses/update',
									  array('status' => $status));
			var_dump($resp);
			
			echo $resp->text . " \n";
			echo $resp->created_at . " \n";
			echo $resp->id . " \n";
		}
	}
	public function account_rate_limit_status()
	{
		$this->auto_render = FALSE;
		if (! isset($_SESSION)) {
		    session_start();	
		}
		if (array_key_exists('access_token', $_SESSION)) {			
			$connection = twitt::er();
			
			$resp = $connection->get('account/rate_limit_status');
			var_dump($resp);
		}
		
		
	}
}