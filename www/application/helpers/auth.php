<?php defined('SYSPATH') OR die('No direct access allowed.');

class auth {
    public static function logged_in()
    {
        return (isset($_SESSION) && array_key_exists('access_token', $_SESSION));
    }
}
?>