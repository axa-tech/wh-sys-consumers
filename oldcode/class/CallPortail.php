<?php

/**
Classe d'appel au portail 

*/
class CallPortail{
	var $proxy="http://10.225.23.242:8080/";
	var $base_url="http://portal.axa-cloud.com";
	var $cookie;
	function __construct(){
		$this->setCookie();
	}
	function getBubbles(){
		//$return=array();
		$url=$this->base_url."/rest/projects/";
		$json= $this->Call($url);
		$tabjson= json_decode($json);
		return $tabjson;
	}
	function getBubble($bubbleid){
		$url=$this->base_url."/rest/projects/".$bubbleid."";
                //$url="http://portal.axa-cloud.com/rest/projects/4/flavors";
                $json= $this->Call($url);
                $tabjson= json_decode($json);
                return $tabjson;
	}
	function getFlavor($bubbleid){
		$url=$this->base_url."/rest/projects/".$bubbleid."/flavors";
		//$url="http://portal.axa-cloud.com/rest/projects/4/flavors";
                $json= $this->Call($url);
                $tabjson= json_decode($json);
                return $tabjson;
	}
	function getImages($bubbleid){
		$url=$this->base_url."/rest/projects/".$bubbleid."/images";
		$json= $this->Call($url);
                $tabjson= json_decode($json);
                return $tabjson;
	}
	function getNetwork($bubbleid){
		$url=$this->base_url."/rest/projects/".$bubbleid."/networks";
                $json= $this->Call($url);
                $tabjson= json_decode($json);
                return $tabjson;
	}
	function getEnvironment($bubbleid){
                $url=$this->base_url."/rest/projects/".$bubbleid."/environments";
                $json= $this->Call($url);
                $tabjson= json_decode($json);
                return $tabjson;
        }
	function setCookie(){
		$this->cookie= "JSESSIONID=FCD040DC23677D6AFAEB2B9FB1ED10E8; path=/; domain=portal.axa-cloud.com; HttpOnly"	;
	}
	function getCookie(){
		return  $this->cookie;
	}
	private function Call($url,$method="GET",$type="",$data="",$verbose=false){
		echo "CALL $url $method : $type : $data ";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
		curl_setopt($ch, CURLOPT_PROXY, "$this->proxy");
//		curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_VERBOSE,$verbose);
	//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
		curl_setopt ($ch, CURLOPT_COOKIE, "$this->cookie" );
	//	curl_setopt ($ch, CURLOPT_HEADER, 1);
		if($type!=""){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/$type",
    			'Content-Length: ' . strlen($data)));
		}
		if($data!=""){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		
		$content=curl_exec($ch);
		echo "FIN DE CURL"; 
		$curl_info = curl_getinfo($ch);
		var_dump($curl_info);
		var_dump($content);
		//die;
		curl_close($ch);
		return $content;
	}
	private function CallApi($url,$data=""){
		$method="PUT";
		$type="json";
		$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_VERBOSE, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_ENCODING, "");
              	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt ($ch, CURLOPT_COOKIE, "$this->cookie" );
                if($type!=""){
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Content-Type: application/$type",
                        'Content-Length: ' . strlen($data))
                        );
                }
                if($data!=""){
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
          //      echo "CURL";
                $content=curl_exec($ch);
                //ho "FIN DE CURL";
                $curl_info = curl_getinfo($ch);
                
	//	var_dump($curl_info);
                //var_dump($content);
                curl_close($ch);
		echo "???";
                return $content;
	}
	/**
	decode json to create a plateform
	*/
	public function decode_message_create($message){
        	$tab = json_decode($message);
        	$bubbleid= $tab->platformRemoteId;
        	$vms=$tab->vms;
        	foreach($vms as $vm){
                	$return = $this->createVM($vm->name,$bubbleid,$vm->adminPass);
			sleep(10);
			$idApi=$vm->id;
			$idVm=$return->providerId;
			$this->updateVmInfos($bubbleid,$idVm,$idApi);
			$this->sendUpdate($bubbleid,$idVm,$idApi);
        	}
		return true;
	}
	private function sendUpdate($bubbleid,$idVm,$idApi,$flavor=false){
		$callrabbit = new CallRabbit();
		$message="{plateformId:$idApi,plateformRemoteId:$bubbleid,idVm:$idVm,flavor:$flavor,comment:update this vm}";//json
		$callrabbit->send($message,"updateplateform");
	}
	public function decode_message_update($message){
		$tab = json_decode($message);
                $bubbleid= $tab->platformRemoteId;
		$idVm=$this->idVm;
		$idApi=$this->idApi;
		$flavor=$this->flavor;
		$timeout=0;
		while($this->getVmStatus =! "started" and $timeout < 3600){
			sleep(5);
			$timeout=$timeout+5;
		}
		if($flavor){
			//STOP
			$this->stopVM($idBubble,$idVm);	
			//CHANGE FLAVOR
			$this->changeFlavor($idBubble,$idVm,$flavor);
			//START
			$this->startVM($idBubble,$idVm);
			
		}
		return $this->updateVmInfos($bubbleid,$idVm,$idApi);
		
		
	}
	public function changeFlavor($idBubble,$idVm,$flavor){
		$flavors=array("SP"=>"NWYxMTg0MGMtYWU1NS00Yzk0LWE5YmUtMTBhMjkxYmExNGQyLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","MP"=>"YjVjNTVhZjAtZTg2Mi00NDhlLWI5Y2QtNWJiMzg1ODkxNzgxLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","LP"=>"ZjMxZDJhMTgtYTI2OS00NzM1LWE5NDctMWIxNWZlNjc3MDBjLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==");
		$idFlavor=$flavors[$flavor];
		$url=$this->base_url."/rest/projects/".$idBubble."/instances/".$idVm;
                $json=$this->Call($url,"PUT","json","{flavorid:$idFlavor}",true);
                $tabjson= json_decode($json);
                return $tabjson;
	}
	public function stopVM($idBubble,$idVm){
		$url=$this->base_url."/rest/projects/".$idBubble."/instances/".$idVm."/stop";
                $json=$this->Call($url,"PUT","","",true);
                $tabjson= json_decode($json);
                return $tabjson;
	}
	public function startVM($idBubble,$idVm){
                $url=$this->base_url."/rest/projects/".$idBubble."/instances/".$idVm."/start";
                $json=$this->Call($url,"PUT","json","",true);
                $tabjson= json_decode($json);
                return $tabjson;
        }
	private function createVM($name,$bubble,$adminPass="password"){
        	$image="MzA4OTJmNDItMWJhZi00MWZkLTg5MTItMDY1OWIwYTBmNTljLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==";
        	$call = new CallPortail();
        	$call->setCookie();
        	$b=$call->getBubble($bubble);
		if($b == null or $b == ""){
			echo "Soucis de cookie ou ... de bubble";
			return false;
			//	exit;
		} else {
        	$f=$call->getFlavor($bubble);
        	$i=$call->getImages($bubble);
        	$n=$call->getNetwork($bubble);
        	$e=$call->getEnvironment($bubble);
        	$subnet=$n[0]->subnets[0]->providerId;
        	$acreate=array("type"=>$b->type,"name"=>$name,"networks"=>$n[0]->providerId,"flavor"=>$f[0]->providerId,"image"=>$image,"adminPass"=>$adminPass,"environmentId"=>$e[0]->providerId,"subnetId"=>$subnet);
        	//var_dump($acreate);
       		$json=json_encode($acreate);
		$url=$this->base_url."/rest/projects/".$bubble."/instances";
        	//$url="http://portal.axa-cloud.com/rest/projects/4/instances";
		$return=$call->Call($url,"POST","json",$json,false);
       	//	var_dump($return);
		echo "VM OK $return";
	//	die;
		return json_decode($return);
		}
		
	}
	public function getVmStatus($idBubble,$idVm){
		$infos=$this->getVmInfos($idBubble,$idVm);
		return $infos->status;
	}
	/**
	*/
	public function getVmInfos($idBubble,$idVm){
		$url=$this->base_url."/rest/projects/".$idBubble."/instances/".$idVm;
                $json=$this->Call($url,"GET","","",true);
                $tabjson= json_decode($json);
		return $tabjson;
	}
	/**
	*/
	public function updateVmInfos($idBubble,$idVm,$idApi){
                $tabjson=$this->getVmInfos($idBubble,$idVm); 
		$tabforapi=array("id"=>$idApi,"VMRemoteId"=>$tabjson->providerId,"name"=>$tabjson->name,"instanceName"=>$tabjson->instanceName,"ip"=>$tabjson->accessIPv4,"state"=>$tabjson->state,"status"=>$tabjson->status);
		$jsonsend=json_encode($tabforapi);
		$this->CallApi("http://api.local/rest/vm/".$idApi,$jsonsend);
		return true;	
	}

}

?>
