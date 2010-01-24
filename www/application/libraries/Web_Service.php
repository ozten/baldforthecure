<?php defined('SYSPATH') or die('No direct script access.');
/* ***** BEGIN LICENSE BLOCK *****
 * Version: MPL 1.1/GPL 2.0/LGPL 2.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * The Original Code is Socorro Crash Reporter
 *
 * The Initial Developer of the Original Code is
 * The Mozilla Foundation.
 * Portions created by the Initial Developer are Copyright (C) 2006
 * the Initial Developer. All Rights Reserved.
 *
 * Contributor(s):
 *   Austin King <aking@mozilla.com> (Original Author)
 *
 * Alternatively, the contents of this file may be used under the terms of
 * either the GNU General Public License Version 2 or later (the "GPL"), or
 * the GNU Lesser General Public License Version 2.1 or later (the "LGPL"),
 * in which case the provisions of the GPL or the LGPL are applicable instead
 * of those above. If you wish to allow use of your version of this file only
 * under the terms of either the GPL or the LGPL, and not to allow others to
 * use your version of this file under the terms of the MPL, indicate your
 * decision by deleting the provisions above and replace them with the notice
 * and other provisions required by the GPL or the LGPL. If you do not delete
 * the provisions above, a recipient may use your version of this file under
 * the terms of any one of the MPL, the GPL or the LGPL.
 *
 * ***** END LICENSE BLOCK ***** */

/**
 * Provide data access to web services. Analygous to Kohana's Database class.
 *
 * Requires a config/webserviceclient.php file with the following
 

$config['defaults'] = array(
    'connection_timeout' => '3',
    'timeout' => '120'
);

//http://bit.ly/account/your_api_key
$config['bitly'] = array('login'  => 'bitlyapidemo',
	                     'apiKey' => 'R_0da49e0a9118ff35f52f629d2d71bf07');
 *
 * You can add other webservice API config in this file also.
 * @author ozten
 */
class Web_Service {
    // config params for use with CURL
    protected $config;
    /**
     * Creates an instance of this class and allows overriding default config
     * @see config/webserviceclient.php for supported options
     */
    public function __construct($config=array())
    {
	$defaults = Kohana::config('webserviceclient.defaults');
	$this->config = array_merge($defaults, $config);

	$required_config_params = array('connection_timeout', 'timeout');
	foreach($required_config_params as $param) {
	    if (! array_key_exists($param, $this->config)) {
		trigger_error("Bad Config for a Web_Service instance, missing required parameter [$param]", E_USER_ERROR);
	    }
	}
    }

    /**
     * Makes a GET request for the resource and parses the response based
     * on the expected type. By default caching is disabled
     * @param string - the url for the web service including any paramters
     * @param string - the expected response type - xml, json, etc
     * @param integer - the lifetime (in seconds) of a cache item or 'default' 
     *                  to use app wide cache default, or lastly NULL to disable caching
     * @return object - the response or FALSE if there was an error
     */
    public function get($url, $response_type='json', $cache_lifetime=NULL)
    {
	if (is_null($cache_lifetime)) {
	    $data = $this->_get($url, $response_type);
	} else {
	    $cache = new Cache();
	    $cache_key = 'webservice_' . md5($url . $response_type);
	    $data = $cache->get($cache_key);
	    if ($data) {
		return $data;
	    } else {
		$data = $this->_get($url, $response_type);
		if ($data) {
		    if ($cache_lifetime == 'default') {
			$cache->set($cache_key, $data);
		    } else {
			$cache->set($cache_key, $data, NULL, $cache_lifetime);
		    }
		}
		return $data;
	    }
	}
    }

    /**
     * Makes a GET request for the resource and parses the response based
     * on the expected type
     * @param string - the url for the web service including any paramters
     * @param string - the expected response type - xml, json, etc
     * @return object - the response or FALSE if there was an error
     */
    private function _get($url, $response_type)
    {
	$curl = $this->_initCurl($url);
	$before = microtime(TRUE);
	$curl_response = curl_exec($curl);
	$after = microtime(TRUE);
	$t = $after - $before;
	if ($t > 3) {
	    Kohana::log('alert', "Web_Service " . $t . " seconds to access $url");
	}
	$headers  = curl_getinfo($curl);
	$http_status_code = $headers['http_code'];
	$code = curl_errno($curl);
	$message = curl_error($curl);
	curl_close($curl);
	Kohana::log('info', "$http_status_code $code $message");
	if ($http_status_code == 200) {
	    if ($response_type == 'json') {
		$data = json_decode($curl_response);
	    } else {
		$data = $curl_response;
	    }	    
	    return $data;
	} else {
	    // See http://curl.haxx.se/libcurl/c/libcurl-errors.html
	    Kohana::log('error', "Web_Service $code $message while retrieving $url which was HTTP status $http_status_code");
	    return FALSE;
	}
    }

    /**
     * Prepares CURL for web serivce calls
     * @param string - the url for the web service including any paramters
     * @return object - handle to the curl instance
     */
    private function _initCurl($url)
    {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->config['connection_timeout']);
	curl_setopt($curl, CURLOPT_TIMEOUT, $this->config['timeout']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_ENCODING , "x-gzip");
	if (array_key_exists('basic_auth', $this->config) &&
	    is_array($this->config['basic_auth'])) {
	        $user = $this->config['basic_auth']['username'];
	        $pass = $this->config['basic_auth']['password'];
		curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $pass);
		Kohana::log('info', "Using $user $pass for basic auth");
	}
	return $curl;
    }

}
?>