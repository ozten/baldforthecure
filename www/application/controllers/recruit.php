<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));

/**
 *
 */
class Recruit_Controller extends Common_Controller {
	public function index()
	{
		if (isset($_SESSION) && array_key_exists('access_token', $_SESSION)) {
			$this->template->title = "Recruit Your Friends for Bald for the Cure";
		    $this->template->content = new View('recruit/index');
			$this->template->content->title = "Recruit Your Friends, Update Your Status";
		} else {
			$this->template->title = "Login Required";
			$this->template->content = new View('recruit/login_required');
		}
	}
	public function tweet($msg)
	{
		$this->auto_render = FALSE;
		//content-type json
		if (isset($_SESSION) && array_key_exists('access_token', $_SESSION)) {
			$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									       Kohana::config("twitteroauth.CONSUMER_SECRET"),
									       $_SESSION['access_token']['oauth_token'],
									       $_SESSION['access_token']['oauth_token_secret']);
			
			#'Firefox 3.6 is ready to bounce tommorrow. It\'s like Christmas in July in January. #Firefox'
			
			$resp = $connection->post('statuses/update',
									  array('status' => $msg));
			echo json_encode($resp);
		} else {
			echo json_encode(array('error' => 'Error: Not logged in'));
		}
	}
	public function friend()
	{
		$this->auto_render = FALSE;
		if (! isset($_SESSION)) {
		    session_start();	
		}
		if (array_key_exists('access_token', $_SESSION)) {
			$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									       Kohana::config("twitteroauth.CONSUMER_SECRET"),
									       $_SESSION['access_token']['oauth_token'],
									       $_SESSION['access_token']['oauth_token_secret']);
			
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
			$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									       Kohana::config("twitteroauth.CONSUMER_SECRET"),
									       $_SESSION['access_token']['oauth_token'],
									       $_SESSION['access_token']['oauth_token_secret']);
			
			$resp = $connection->get('account/rate_limit_status');
			var_dump($resp);
		}
		
		
	}
}