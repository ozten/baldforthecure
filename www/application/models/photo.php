<?php defined('SYSPATH') OR die('No direct access allowed.');
class Photo_Model extends ORM
{
    public static $before_type  = "BEFR";
    public static $after_type   = "AFTR";
    public static $unknown_type = "UNKN";
    
    public static $flickrtags = array(
		'BEFR' => 'before',
		'AFTR' => 'after',
    );
    
    protected $belongs_to = array('user');
}
?>