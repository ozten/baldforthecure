<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));

class Profile_Controller extends Common_Controller {

	public function index($username)
	{
		$user = ORM::factory('user')->where('username', $username)->find();
		
		// In Kohana, all views are loaded and treated as objects.
		$this->template->content = new View('profile/index');

		$this->template->title = "{$user->username} Bald for a Cure Profile";
		$this->template->content->user = $user;
		
		$photos = $user->photos;
		
		$loaderboard_city = ORM::factory('city')->where('id', strtolower($user->city_id))->find();
		echo $loaderboard_city->name;
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