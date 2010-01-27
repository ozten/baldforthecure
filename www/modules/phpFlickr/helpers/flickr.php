<?php defined('SYSPATH') OR die('No direct access allowed.');
require_once(Kohana::find_file('libraries', 'phpFlickr', TRUE, 'php'));
class flickr
{
    public static function makeFlickr()
    {
        $keys = Kohana::config('flickr.keys');        
        $f = new phpFlickr($keys['key'], $keys['secret']);
        $f->setToken($keys['token']);        
        return $f;
    }
    public static function userId()
    {
        return Kohana::config('flickr.user_id');
    }
    public static function search($args)
    {
        return self::makeFlickr()->photos_search($args);   
    }
    public static function uploadSync($photo, $title, $description, $tags)
    {
        return self::makeFlickr()->sync_upload ($photo, $title, $description, $tags);
    }

    public static function url($photo, $size='Medium')
    {
        return self::makeFlickr()->buildPhotoURL($photo, $size);
    }
}
?>