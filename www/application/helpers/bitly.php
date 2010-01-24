<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * requires libraries/Web_Service.php and config/webserviceclient.php
 */
class bitly {
    public static function shorten($url)
    {
        try {
            $service = new Web_Service;
            $config = Kohana::config('webserviceclient.bitly');
            
            $bitly_endpoint = "http://api.bit.ly/shorten?" . http_build_query(array(
                'longUrl' => $url,
                'version' => '2.0.1',
                'login'   => $config['login'],
                'apiKey'  => $config['apiKey'],
                'format'  => 'json',
            ));
            
            $bitly = $service->get($bitly_endpoint, 'json', 60 * 60 * 24 * 14);
            if ($bitly->errorCode) {
                Kohana::log('error', "bitly error code: " . $bitly->errorCode .
                           " message - " . $bitly->errorMessage);
                //fall through
            } else {                
                return $bitly->results->{$url}->shortUrl;
            }
        } catch(Exception $e) {
            Kohana::log('error', $e);
            //fall through
        }
        return $url;
    }
}
?>