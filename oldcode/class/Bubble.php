<?php
/**

*/
class Bubble {
     	private $id;
	var $name;
	private $environmentId;
	private $networkId;
	private $subnetId;
	private $endPoint;
	var $type;
    	function __construct($id,$name,$type,$endPoint){
		$this->id=$id;
		$this->name=$name;
		$this->type=$type;
		$this->endPoint=$endPoint;
	}

	function setId($id){
		$this->id=$id;
	}
	function setEnvironmentId($environmentId){
		$this->environmentId=$environmentId;
	}
	function setNetworkId($networkId){
		$this->networkId=$networkId;
	}
	function setSubnetId($subnetId){
		$this->subnetId=$subnetId;
	}
	function setName($name){
		$this->name=$name;
	} 
	function getId($id){
                return $this->id;
        }
        function getEnvironmentId($environmentId){
                return $this->environmentId;
        }
        function getNetworkId($networkId){
                return $this->networkId;
        }
        function getSubnetId($subnetId){
                return $this->subnetId;
        }
        function getName($name){
                return $this->name;
        }



}

?>
