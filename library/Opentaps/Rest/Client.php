<?php

require_once 'Zend/Http/Client.php';
require_once 'Zend/Json.php';


class Opentaps_Rest_Client extends Zend_Http_Client {

    protected $httpClient;
    protected $username;
    protected $password;
    
    protected $serviceUri;
    protected $resourcePath = '';
    

    public function __construct($uri = null, $config = null) {
        parent::__construct(null, $config);

        $this->setServiceUri($uri);
        $this->config['useragent'] = 'Opentaps REST Client';
    }
        
    
    public function factory() {
    }
    

    public function setUri($uri) {
//    	parent::setUri($uri);
    	$this->serviceUri = $uri;
		
		return $this;
    }
    
    
    public function request($method = null) {
//    	var_dump("URI: ", $this->serviceUri . $this->resourcePath);
    	parent::setUri($this->serviceUri . $this->resourcePath);
    	return parent::request($method);
    }
    

    public function setServiceUri($uri) {
//    	var_dump("setServiceUri");
    	$this->serviceUri = $uri;
    }
    
    
    public function getServiceUri() {
    	var_dump("getServiceUri");
    	return $this->serviceUri;
    }
    
    
    public function setResourcePath($resourcePath = '') {
    	$this->resourcePath = $resourcePath;
    }
    
    
    public function getResourcePath() {
    	return $this->resourcePath;
    }
    
    
    public function setUsername($username) {
    	$this->username = $username;
		$this->setHeaders('username: ' . $username);
		
		return $this;
    }
    
    
    public function setPassword($password) {
		$this->password = $password;
		$this->setHeaders('password: ' . $password);
		
		return $this;
    }
    
}

?>
