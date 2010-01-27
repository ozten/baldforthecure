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
    
    public $username;
    
    /*** update area support ***/
    public function username()
    {
        return $this->user->username;
    }
    public function action()
    {
        $this->username = $this->user_id;
        return "uploaded";
    }
    public function show()
    {
        return "<img src='" . $this->url . "' width='" . $this->width . "' height='" . $this->height . "' />";
    }
}
?>