<?php
use Guzzle\Http\Client;
/**
*/
class Portail{
	var $proxy="http://10.225.23.242:8080/";
	var $base_url="http://portal.axa-cloud.com/";
	var $cookie="";
	var timeout = 60;
	function __construct(){
		$this->$client = new Client();
	}
	public function setCookie($cookie){
		$this->cookie=$cookie;
	}
	/**
		POST A JSON
	*/
	public function post($suffix,$jsondata){
		return $response = $this->client->post($this->$base_url.$suffix	, [
			'headers' => ['Content-Type' => 'application/json', "Content-Length" => strlen($jsondata)],
			'proxy'	  => $this->proxy,
			'timeout' => $this->timeout,
			'cookies' => ['JSESSIONID' => $this->cookie.'; path=/; domain=portal.axa-cloud.com; HttpOnly']
		]);
	}
	public function put($suffix,$jsondata){
		return $response = $this->client->put($this->$base_url.$suffix	, [
			'headers' => ['Content-Type' => 'application/json', "Content-Length" => strlen($jsondata)],
			'proxy'	  => $this->proxy,
			'timeout' => $this->timeout;
			'cookies' => ['JSESSIONID' => $this->cookie.'; path=/; domain=portal.axa-cloud.com; HttpOnly']
		]);
	}
	public function get($suffix){
		return $response = $this->client->get($this->$base_url.$suffix	, [
			'proxy'	  => $this->proxy,
			'timeout' => $this->timeout;
			'cookies' => ['JSESSIONID' => $this->cookie.'; path=/; domain=portal.axa-cloud.com; HttpOnly']
		]);
	}
	
}
	
?>