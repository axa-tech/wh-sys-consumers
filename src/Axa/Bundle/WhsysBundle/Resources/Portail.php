<?php
use Guzzle\Http\Client;
/**
 * CLass Portail for call the portail
 *
*/
class Portail{
	var $proxy="http://10.225.23.242:8080/";
	var $base_url="http://portal.axa-cloud.com/";
	var $cookie="";
	var timeout = 60;
    /**
     *
     */
    function __construct(){
		$this->$client = new Client();
	}

    /**
     * @param $cookie
     */
    public function setCookie($cookie){
		$this->cookie=$cookie;
	}

    /**
     * @param $suffix
     * @param $jsondata
     * @return mixed
     */
    public function post($suffix,$jsondata){
		return $response = $this->client->post($this->$base_url.$suffix	, [
			'headers' => ['Content-Type' => 'application/json', "Content-Length" => strlen($jsondata)],
			'proxy'	  => $this->proxy,
			'timeout' => $this->timeout,
			'cookies' => ['JSESSIONID' => $this->cookie.'; path=/; domain=portal.axa-cloud.com; HttpOnly']
		]);
	}

    /**
     * @param $suffix
     * @param $jsondata
     * @return mixed
     */
    public function put($suffix,$jsondata){
		return $response = $this->client->put($this->$base_url.$suffix	, [
			'headers' => ['Content-Type' => 'application/json', "Content-Length" => strlen($jsondata)],
			'proxy'	  => $this->proxy,
			'timeout' => $this->timeout,
            'cookies' => ['JSESSIONID' => $this->cookie.'; path=/; domain=portal.axa-cloud.com; HttpOnly']
		]);
	}

    /**
     * @param $suffix
     * @return mixed
     */
    public function get($suffix){
		return $response = $this->client->get($this->$base_url.$suffix	, [
			'proxy'	  => $this->proxy,
			'timeout' => $this->timeout,
			'cookies' => ['JSESSIONID' => $this->cookie.'; path=/; domain=portal.axa-cloud.com; HttpOnly']
		]);
	}
	
}
	
?>