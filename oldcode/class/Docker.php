<?php

class Docker{
	var $id;
	var $url;
	var $confs;
	var $imageid="90";
	var $url_registry="http://10.226.0.135:5000/haproxy";
	var $bin="docker -d ";
	var $options=" -t -i ";
	public function start(){
		foreach($this->confs as $type => $conf){
			$pathtoconf = $this->download_conf($conf[0],$type);
			$stringconfs .= " -v ". $pathtoconf.":".$conf[1]." ";
		}
		$cmd = $this->bin.$stringconfs.$this->options.$this->imageid." /bin/bash ";
		echo "EXEC=> ".$cmd."\n";
		$this->pull();
		system($cmd);	
		
	}
	public function stop(){
		//
	}
	public function restart(){
		$this->stop;
		$this->start;
	}
	private function pull(){
		$cmd="docker pull ".$this->url_registry."/".$this->imageid;
		echo "Pull => ".$cmd."\n";
		//system($cmd);
	}
	private function download_conf($url,$type){
		$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
                curl_setopt($ch, CURLOPT_VERBOSE, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_ENCODING, "");
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                $content=curl_exec($ch);
                $curl_info = curl_getinfo($ch);
                curl_close($ch);
		$dir="/tmp/";	
		$file=$dir.$type.".conf";
		$fp = fopen($file, 'w');
		fwrite($fp, $content);
		fclose($fp);
		return $file;
	}
	function __construct($id,$imageid,$confs){
		$this->id=$id;
		$this->imageid=$imageid;
		$this->confs=$confs;

	}

}






?>
