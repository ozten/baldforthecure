<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));

/**
 * This controller is the canonical reference for what should be
 * in the users SESSIOn. Currently a logged in user has
 *  username - Twitter screenname at the time of signup
 *  userid - B4TC user id - main key used in the database
 *  access_token - Twitter access token
 */
class OAuth_Controller extends Common_Controller {
	public function login()
	{
		$this->auto_render = FALSE;
		if (! isset($_SESSION)) {
		    session_start();	
		}
		
		$callback_url    = url::site(Kohana::config("twitteroauth.OAUTH_CALLBACK"));
		// login
		$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"), Kohana::config("twitteroauth.CONSUMER_SECRET"));
		
		$request_token = $connection->getRequestToken($callback_url);
		// Seeing Failed to validate oauth signature and token
		// Then do sudo ntpdate ntp.ubuntu.com
		
		/* Save request token to session */
        $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		
		Kohana::log('debug', "Twitter request tokens - " . Kohana::debug($request_token));

		/* If last connection fails don't display authorization link */
		switch ($connection->http_code) {
		  case 200:
		    /* Build authorize URL */
		    $url = $connection->getAuthorizeURL($token);
		    header('Location: ' . $url); 
		    break;
		  default:
		    echo 'Could not connect to Twitter. Refresh the page or try again later.';
		    break;
		}
		return;
	}
	
	public function success()
	{
		$this->auto_render = FALSE;
				
		/*$consumer_key    = "SfM2iXdD4FyjbsTT1AFQ";
		$consumer_secret = "5DYzuGXPo3bZOBiigUjQDfYZqMLwNSa21iOiaoy1Cs";
		*/
		if (! isset($_SESSION)) {
		    session_start();	
		}
		/* If the oauth_token is old redirect to the connect page. */
		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
		  $_SESSION['oauth_status'] = 'oldtoken';		  
		}
		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									   Kohana::config("twitteroauth.CONSUMER_SECRET"),
									   $_SESSION['oauth_token'],
									   $_SESSION['oauth_token_secret']);
		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['access_token'] = $access_token;
	
		/* Remove no longer needed request tokens */
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);


		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
		  $this->saveUser($access_token);
		} else {
		  /* Save HTTP status for error dialog on connnect page.*/
		  //header('Location: ./clearsessions.php');
		  echo "No dice";
		}
	}
	
	public function saveUser($access_token)
	{				
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									   Kohana::config("twitteroauth.CONSUMER_SECRET"),
									   $access_token['oauth_token'],
									   $access_token['oauth_token_secret']);
		
		$user = $connection->get('account/verify_credentials');
		$username = trim($user->screen_name);
		$_SESSION['username'] = $username;		
		Kohana::log('debug', "Searching for " . $user->screen_name);
		$existing_user = ORM::factory('user')->where('username', trim($user->screen_name))->find();
		$user_id = -1;
		if ($existing_user->loaded) {
			Kohana::log('debug', "Found user, skipping creation");
			# uncomment below to allow multiple recruit credits, otherwise, we'll only
			# record the inital recruit when user account is created
			# $this->saveRecruiter($existing_user);
			$user_id = $existing_user->id;
		} else {
			Kohana::log('debug', "New user, creating");
			
			$id = intval($user->id);
			$name     = $this->notNullOr($user->name, "Unknown");
			$avatar   = $this->notNullOr($user->profile_image_url, '/i/unknown_avatar.jpg');
			$city     = $this->notNullOr($user->location, "Unknown City");
			
			$u = ORM::factory('user');
			$u->username   = $username;
			$u->twitter_id = $id;
			$u->name       = $name;
			$u->city       = $city;
			$u->avatar     = $avatar;

		    /* The user has been verified and the access tokens can be saved for future use */	
			$u->twitter_oauth_token        = $access_token['oauth_token'];
			$u->twitter_oauth_token_secret = $access_token['oauth_token_secret'];
			
			$u->save();
			$user_id = $u->id;
			$this->saveRecruiter($u);
		}
		
		$_SESSION['username'] = $username;
		if ($user_id != -1) {
			$_SESSION['userid'] = $user_id;	
		}
		
		$this->_repairSocialGraph($user_id);
		
		// redirect
		url::redirect('/profile/index/' . $username);
	}
	
	protected function saveRecruiter($model)
	{
		if (array_key_exists('recruiter', $_SESSION)) {
			$g = new Recruit_Model;
			$g->saveRecruit($_SESSION['recruiter'], $model->id);
			unset($_SESSION['recruiter']);
		} else {
			Kohana::log('debug', "No recruiter info present");
		}
	}
	
	public function logout()
	{
		$this->auto_render = FALSE;
		if (! isset($_SESSION)) {
		    session_start();	
		}
		session_destroy();
		url::redirect('/');
	}
	
	protected function notNullOr($value, $default)
	{
		if (is_null($value) ||
			trim($value) == '') {
			return $default;
		} else {
			return trim($value);
		}
	}
	
	protected function twitterIfLoggedIn()
	{
		if (isset($_SESSION) &&
		    array_key_exists('username', $_SESSION) &&
			array_key_exists('access_token', $_SESSION)) {
			return new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									       Kohana::config("twitteroauth.CONSUMER_SECRET"),
									       $_SESSION['access_token']['oauth_token'],
									       $_SESSION['access_token']['oauth_token_secret']);
		
		}
		return FALSE;
	}
	
	public function repairSocialGraph()
	{
		$this->auto_render = FALSE;
		$twitter = $this->twitterIfLoggedIn();
		
		if ($twitter != FALSE) {
			$this->_repairSocialGraph($_SESSION['userid']);			
		} else {
			header('Bad request', TRUE, 400);
			echo "I got nothing for ya man.";
		}
	}
	
	public function _repairSocialGraph($user_id)
	{
		Kohana::log('info', "_repairSocialGraph called");
		$twitter = $this->twitterIfLoggedIn();
		
		if ($twitter != FALSE) {
			Kohana::log('info', "hitting twitter");
				$ids = $twitter->get('friends/ids');
				$friend_ids = array();
				foreach($ids as $id) {
					array_push($friend_ids, intval($id));
				}
				$existing_users = ORM::factory('user')->get_users_by_twitter_ids($friend_ids);
				$existing_user_ids = array();
				foreach($existing_users as $existing_user) {
					array_push($existing_user_ids, $existing_user->twitter_id);
				}
				
				$model = new Users_Friend_Model;
				$existing_friends = $model->get_old_friends($user_id);
								
				$existing_friend_ids = array();
				foreach($existing_friends as $existing_friend) {
					array_push($existing_friend_ids, $existing_friend->friend_twitter_id);					
				}
				$new_user_ids = array_diff($friend_ids, $existing_user_ids, $existing_friend_ids);				
				
				$model = new Users_Friend_Model;
				$model->add_new_friends($user_id, $new_user_ids);
		} else {
			Kohana::log('info', "Missing session variables to setup twitter");
		}
	}
	
	public function repairAvatar()
	{
		$this->auto_render = FALSE;
		$twitter = $this->twitterIfLoggedIn();
		
		if ($twitter != FALSE) {

			$info = $twitter->get('users/show', array(
				'screen_name' => $_SESSION['username'],
			));
			//echo Kohana::debug($info);
			
			echo $info->profile_image_url;
			$user = ORM::Factory('user')->where('username', $_SESSION['username'])->find();
			$user->avatar = $info->profile_image_url;
			$user->save();
			
		} else {
			header('Bad request', TRUE, 400);
			echo "I got nothing for ya man. You want 10 dollars for what?";
		}
		
	}
	
	public function showAccount()
	{		
		/* Get user access tokens out of the session. */
		$access_token = $_SESSION['access_token'];
		
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
									   Kohana::config("twitteroauth.CONSUMER_SECRET"),
									   $access_token['oauth_token'],
									   $access_token['oauth_token_secret']);
		
		/* If method is set change API call made. Test is called by default. */
		$content = $connection->get('account/rate_limit_status');
		echo "Current API hits remaining: {$content->remaining_hits}.";
		
		/* Get logged in user to help with tests. */
		$user = $connection->get('account/verify_credentials');
		
		echo "<p>Welcome back {$user->name} <img src='{$user->profile_image_url}' /></p>";
		echo "<p>City: {$user->location}</p>";
		echo "<p></p>";
		var_dump($user);
		$this->template->content = new View('welcome_content');

		// You can assign anything variable to a view by using standard OOP
		// methods. In my welcome view, the $title variable will be assigned
		// the value I give it here.
		$this->template->title = 'Welcome to Kohana!';
		
	}
	// http://bald.ubuntu/oauth/flickr_success?frob=72157623286479286-dd7560d46aeb7dd6-165532&extra=%2Fprofile%2Findex%2Fozten
	public function flickr_success()
	{
		$this->auto_render = FALSE;
		$flickr = flickr::makeFlickr();
		
		$flickr->auth_getToken($this->input->get('frob'));
		url::redirect($this->input->get('extra'));
	}
}