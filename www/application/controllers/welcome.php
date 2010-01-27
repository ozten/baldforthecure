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
class Welcome_Controller extends Common_Controller {
	#public $template = 'template';

	public function index()
	{
		$this->template->title = 'The Latest';
		
		$this->template->content = new View('welcome/index');
		$this->template->content->title = "The Latest";
		$this->template->content->total_pledges = 7500;#TODO
		$this->template->content->updates = $this->latestUpdates();
		
		$this->template->content->city_leader = new View('widgets/leaderboard');
		$this->template->content->city_leader->type = "Best Cities";
		$this->template->content->city_leader->total_type = "Cash Raised";
		$city_leaders = ORM::factory('city_leaderboard')->orderby('id', 'DESC')->limit(10)->find_all();
		$citys = array();
		foreach ($city_leaders as $city_leader) {
			array_push($citys, array($city_leader->city, "$" . $city_leader->total));
		}
		$this->template->content->city_leader->leaders = $citys;
		
		$this->template->content->people_leader = new View('widgets/leaderboard');
		$this->template->content->people_leader->type = "Best Fundraisers";
		$this->template->content->people_leader->total_type = "Cash Raised";
		# TODO grab full name in cron 
		$pledgers = ORM::factory('user_pledge_leaderboard')->orderby('id', 'DESC')->limit(10)->find_all();
		$pledges = array();
		foreach($pledgers as $p) {
			array_push($pledges, array($p->user_id, "$" . $p->total));
		}
		$this->template->content->people_leader->leaders = $pledges;
		
		$this->template->content->recruit_leader = new View('widgets/leaderboard');
		$this->template->content->recruit_leader->type = "Best Recruiters";
		$this->template->content->recruit_leader->total_type = "Recruits";
		# TODO grab full name in cron 
		$recruiters = ORM::factory('user_recruit_leaderboard')->orderby('id', 'DESC')->limit(10)->find_all();
		$recruits = array();
		foreach($recruits as $r) {
			array_push($recruits, array($r->user_id, $r->total));
		}
		$this->template->content->recruit_leader->leaders = $recruits;
		
		$this->template->content->user_city_leader = new View('widgets/leaderboard');
		$this->template->content->user_city_leader->type = "Top User in Seattle, WA";
		$this->template->content->user_city_leader->total_type = "Pledges";		
		$city_pledges = ORM::factory('user_pledge_leaderboard')->join('cities', 'cities.id', 'user_pledge_leaderboards.city_id')->where('name', 'Seattle, WA')->orderby('id', 'DESC')->limit(10)->find_all();
		$cities = array();
		foreach ($city_pledges as $c) {
			array_push($cities, $c->user_id, "$" . $c->total);
		}
		$this->template->content->user_city_leader->leaders = $cities;
		
		
	}

	public function latestUpdates()
	{
		$limit = 10;
		$users = ORM::factory('user')->orderby('created', 'DESC')->find_all($limit);
		#$photos = ORM::factory('photo')->join('users', 'photos.user_id', 'users.id')->orderby('created', 'DESC')->find_all($limit);
		$photos = ORM::factory('photo')->with('user')->orderby('created', 'DESC')->find_all($limit);
		$updates = array();
		foreach($users as $user) {
			array_push($updates, $user);
		}
		foreach($photos as $photo) {
			array_push($updates, $photo);
		}
		return $updates;
	}

}