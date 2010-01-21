<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));

/**
 * Default Kohana controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Common_Controller extends Template_Controller {
	public $template = 'template';
	public $user_widget = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->recognizeUser();
	}
	
	protected function recognizeUser()
	{
		echo "Session " . isset($_SESSION);
		if (! isset($_SESSION)) {
			//TODO: Work out minimal session access
		    session_start();
		}
		
		if (array_key_exists('username', $_SESSION)) {
			$this->template->user_widget = new View('widgets/logout');
			$this->template->user_widget->username = $_SESSION['username'];
		} else {
			$this->template->user_widget = new View('widgets/login');
		}
		
		// Widget - 
		// Is there a username in the session
		// display username
		// otherwise display login link
		
		// oauth controller
		// login
		
		
	}
	public function twitterAuth()
	{
		
		
		
	}
}