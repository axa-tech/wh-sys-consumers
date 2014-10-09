<?php
/**
Class Object Vm
*/
class Vm{
	var name;
	var bubbleid;
	var adminPass;
	var idApi;
	var idPortail;
	var imageId="MzA4OTJmNDItMWJhZi00MWZkLTg5MTItMDY1OWIwYTBmNTljLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==";
	var $flavors=array("SP"=>"NWYxMTg0MGMtYWU1NS00Yzk0LWE5YmUtMTBhMjkxYmExNGQyLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","MP"=>"YjVjNTVhZjAtZTg2Mi00NDhlLWI5Y2QtNWJiMzg1ODkxNzgxLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","LP"=>"ZjMxZDJhMTgtYTI2OS00NzM1LWE5NDctMWIxNWZlNjc3MDBjLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==");

    function __contruct($name,$bubbleid,$adminPass,$idApi="",$idPortail=""){
		$this->name=$name;
		$this->bubbleid=$bubbleid;
		$this->adminPass=$adminPass;
		$this->idApi=$idApi;
		$this->idPortail=$idPortail;
		$this->Portail=new Portail();
		$this->setMetadata();
	}
	public function setImageId($image){
		$this->imageId=$image;
	}
	public function getImageId(){
		return $this->imageId;
	}
	public function setMetadata(){
		$this->bubble=$this->Portail->get("/rest/projects/".$this->bubbleid);
       	$this->flavor=$this->Portail->get("/rest/projects/".$this->bubbleid."/flavors");
       	$this->network=$flavor=$this->Portail->get("/rest/projects/".$this->bubbleid."/networks");
       	$this->environnement=$flavor=$this->Portail->get("/rest/projects/".$this->bubbleid."/environments");
       	$this->subnet=$this->network[0]->subnets[0]->providerId;
	}
	public function create(){
       	$acreate=array("type"=>$this->bubble->type,"name"=>$this->name,
			"networks"=>$this->network[0]->providerId,
			"flavor"=>$this->flavor[0]->providerId,
			"image"=>$this->image,
			"adminPass"=>$this->adminPass,
			"environmentId"=>$this->environnement[0]->providerId,
			"subnetId"=>$this->subnet);
  		$json=json_encode($acreate);
		$return=$this->Portail->post("/rest/projects/".$this->bubbleid."/instances",$json);
		Api::updateVmInfos($return,$this->idApi);
	}
	public function remove(){
		return $this->Portail->put("/rest/projects/".$this->bubbleid."/instances/".$this->idPortail."/remove");
	}
	public function start(){
		return $this->Portail->put("/rest/projects/".$this->bubbleid."/instances/".$this->idPortail."/start");
	}
	public function stop(){
		return $this->Portail->put("/rest/projects/".$this->bubbleid."/instances/".$this->idPortail."/stop");
	}
	public function resize($flavorcode){
		$this->stop();
		$idFlavor=$this->flavors[$flavorcode];
		$url=$this->Portail->put("/rest/projects/".$this->bubbleid."/instances/".$this->idPortail,"{flavorid:".$idFlavor."}");
		$this->start();
	}
	public function getStatus(){
		return $this->Portail->get("/rest/projects/".$this->bubbleid."/instances/".$this->idPortail);
	}
	
}

?>
