<?php

require_once('config.php');

class WufooGetter {
  
  private $url;
  private $config;
  
	public function __construct($url, $config) {
	  $this->url = $url;
	  $this->config = $config;
	}
	
	public function makeCall() {

  	$curl = curl_init('https://'.$this->config->subdomain.'.wufoo.com/'.$this->url);       
  	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);                     
  	curl_setopt($curl, CURLOPT_USERPWD, $this->config->apiKey.':footastic');  
  	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                    
  	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);                          
  	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);                           
  	curl_setopt($curl, CURLOPT_USERAGENT, 'Wufoo Sample Code');            

  	$response = curl_exec($curl);                                          
  	$resultStatus = curl_getinfo($curl);                                  
  	
  	// This is fairly primitive error handling.
  	// The jQuery plugin tests for the type of the response and 
  	// deals with it over there.
  	
  	if ($resultStatus['http_code'] == 200) {                    
  	    echo $response;
  	} else {
  	  
  	    // Some folks may want to encode the error as JSON before 
  	    // outputting, so the JavaScript gets usable data no matter what.
  	  
  	    echo 'Call Failed '.print_r($resultStatus);                        
  	}
  	  	
	}
	
}

$wufooGetter = new WufooGetter($_GET['url'], new jQueryConfig());
$wufooGetter->makeCall();

?>