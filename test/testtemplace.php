<?php
require "vendor/autoload.php";
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('/media/sf_vagrant/');
//$template = $twig->loadTemplate('haproxy.cfg.twig');
//echo $template->render(array());
//echo $twig->render('haproxy.cfg.twig',array());
    
    $twig = new Twig_Environment($loader, array(
      'cache' => false
    ));

$template = $twig->loadTemplate('haproxy.cfg.twig');
    echo $template->render(array(
		'domains' => 
			array(	
			"Finance.com" => array("backendname"=>"finance","fqdn"=>"finance.axa.com"),
			"assistance.com"=> array("backendname"=>"assistance","fqdn"=>"ass.axa.com")
			) , 
		"backends"=>
				array(
					"finance"=>array("name"=>"finance","hosts"=>array("1"=>array("ip"=>"127.0.0.1","port"=>"3001"),"2"=>array("ip"=>"127.0.0.1","port"=>"3002"))),
					"assistance"=>array("name"=>"assistance","hosts"=>array("1"=>array("ip"=>"127.0.0.1","port"=>"3001"),"2"=>array("ip"=>"127.0.0.1","port"=>"3002")))
				
				))); 


?>
