<?php defined('SYSPATH') OR die('No direct access allowed.');
require_once(Kohana::find_file('libraries', 'twitteroauth', TRUE, 'php'));
class twitt
{
    /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
    public static function er()
    {
        return new TwitterOAuth(Kohana::config("twitteroauth.CONSUMER_KEY"),
								Kohana::config("twitteroauth.CONSUMER_SECRET"),
								$_SESSION['access_token']['oauth_token'],
								$_SESSION['access_token']['oauth_token_secret']);
		
    }
}
?>