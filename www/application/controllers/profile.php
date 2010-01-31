<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));
require_once(Kohana::find_file('libraries', 'phpFlickr', TRUE, 'php'));
class Profile_Controller extends Common_Controller {

	public function index($username)
	{
		$user = ORM::factory('user')->where('username', $username)->find();
		$this->template->set_global('donate_shaver_user_id', $user->id);
		
		#$this->showPhotos();
		$error_messages = array();
		$current_users_profile = FALSE;
		if (isset($_SESSION)) {
			if (isset($_SESSION['processing_error'])) {
				$error_messages = $_SESSION['processing_error'];
				unset($_SESSION['processing_error']);
			}
			
			
			if (array_key_exists('username', $_SESSION) &&
				$_SESSION['username'] == trim($username)) {
				$current_users_profile = TRUE;
			}
		}
		
		// In Kohana, all views are loaded and treated as objects.
		$this->template->content = new View('profile/index');

		$this->template->title = "{$user->username} Bald for a Cure Profile";
		$this->template->content->user = $user;
		$this->template->error_messages = $error_messages;
		$this->template->set_global('current_users_profile', $current_users_profile);
		$photos = $user->photos;
		
		$loaderboard_city = ORM::factory('city')->where('id', strtolower($user->city_id))->find();
		
		$before = NULL;
		$after = NULL;
		foreach($photos as $photo) {
			if ($photo->type == Photo_Model::$before_type) {
				$before = $photo;
			} else if ($photo->type == Photo_Model::$after_type) {
				$after = $photo;
			}
		}
		$this->template->content->before = $before;
		$this->template->content->after = $after;
		
		#$this->createPhoto($user);
	}
	
	protected function showPhotos()
	{
		$photos = flickr::search(array(
			'user_id' => flickr::userId(),
			'tags' => 'Radio8ballshow',
		));
		echo Kohana::debug($photos);
	
		if ($photos) {
			foreach ($photos['photo'] as $photo) {
				if (is_array($photo) && array_key_exists('farm', $photo)) {
					//$owner = $f->people_getInfo($photo['owner']);
					//echo "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
					echo "<img src='http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . ".jpg' />";
					echo $photo['id'];
					echo $photo['title'];
					echo "</a> Owner: ";
					echo "<a href='http://www.flickr.com/people/" . $photo['owner'] . "/'>";
					//echo $owner['username'];
					echo "</a><br>";	
				} else {
					echo "Ouch seeing photo " . Kohana::debug($photo);
				}
			}
		}
	}
	
	
	public function createPhoto($user)
	{
		
		$p = ORM::factory('photo');
		
		$p->user_id = $user->id;
		$p->type = Photo_Model::$after_type;
		$p->url = 'http://bald.ubuntu/i/IMG_6905.jpg';
		$p->width = 400;
		$p->height = 600;
		//TODO what is the right format for data into here?
		$p->created = time();		
		$p->save();
	}
	
	public function createOzten()
	{
		$u = ORM::factory('user');
		$u->username = "ozten";
		$u->twitter_id = 123456;
		$u->name = "Austin King";
		$u->city = "Seattle, WA";
		$u->avatar = "http://bald.ubuntu/i/avatars/ozten.jpg";
		
		echo $u->save();
	}
}