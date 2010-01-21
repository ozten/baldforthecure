<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Keeps track of two types of activities
 * PLDG - People with the highest number of pledges
 * RCRT - People who have recruited the most other users
 */
class User_Leaderboard_Model extends ORM
{
    public static $pledge_type  = 'PLDG';
    public static $recruit_type = 'RCRT';
}
?>