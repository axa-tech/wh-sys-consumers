<?php
use Guzzle\Http\Client;
/**
*/
class Api{
	var $base_url="http://api.local/";
	private timeout = 60;
	function __construct(){
		$this->$client = new Client();
	}
	/**
		POST A JSON
	*/
	public function post($suffix,$jsondata){
		return $response = $this->client->post($this->$base_url.$suffix	, [
			'headers' => ['Content-Type' => 'application/json', "Content-Length" => strlen($jsondata)],
			'timeout' => $this->timeout;
		]);
	}
	public function put($suffix,$jsondata){
		return $response = $this->client->put($this->$base_url.$suffix	, [
			'headers' => ['Content-Type' => 'application/json', "Content-Length" => strlen($jsondata)],
			'timeout' => $this->timeout;
		]);
	}
	public function get($suffix){
		return $response = $this->client->get($this->$base_url.$suffix	, [
			'timeout' => $this->timeout;
		]);
	}
	public function updateVmInfos($info,$idApi){
		$tabjson=json_decode($info); 
		$tabforapi=array("id"=>$idApi,"VMRemoteId"=>$tabjson->providerId,"name"=>$tabjson->name,"instanceName"=>$tabjson->instanceName,"ip"=>$tabjson->accessIPv4,"state"=>$tabjson->state,"status"=>$tabjson->status);
		$jsonsend=json_encode($tabforapi);
		return $this->put("/rest/vm/".$idApi,$jsonsend);
	}
}
	
?>