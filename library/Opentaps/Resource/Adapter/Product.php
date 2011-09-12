<?php

require_once 'Opentaps/Resource/Adapter/Abstract.php';
require_once 'Opentaps/Resource/Exception.php';


class Opentaps_Resource_Adapter_Product extends Opentaps_Resource_Adapter_Abstract {

	const TYPE   		  = 'PRODUCT';
	const PATH			  = "/products";
	

    function __construct() {
        $this->path = self::PATH;
    }
    
    
    function getProducts() {
		try {
			$result = $this->client->request('GET');
//			var_dump($result);
//			var_dump($result->getBody());
			$responseObj = Zend_Json::decode($result->getBody(), Zend_Json::TYPE_OBJECT);
//			var_dump($responseObj, $responseObj->response);
		} catch (Exception $e) {
//			var_dump("Error", $e->getMessage());
			throw new Opentaps_Resource_Exception($e->getMessage());
		}
		
		if ($responseObj->response->status == "error") {
//			var_dump("Throw exception"); return false;
			throw new Opentaps_Resource_Exception($responseObj->response->message);
		}
		
        // JSON returns an array of product objects,
        // so we reassign those to be directly accessible via products property
        $responseObj->response->products = $responseObj->response->products->product;

        return $responseObj->response;
//		var_dump($this->client->getLastRequest());
    }
    
/*
    function createProduct($lead) {
		// TODO move these to config parameters
    	$this->client->setHeaders('Content-Type: application/json');
		$this->client->setHeaders('Accept: application/json');
		
		try {
			$this->client->setRawData(json_encode($lead))->setEncType($this->encType);
			
			$result = $this->client->request('POST');
//			var_dump($result);
//			var_dump($result->getBody());
			$responseObj = Zend_Json::decode($result->getBody(), Zend_Json::TYPE_OBJECT);
//			var_dump($responseObj, $this->client->getLastResponse());
		} catch (Exception $e) {
            throw new Opentaps_Resource_Exception($e->getMessage());
//			var_dump("Error", $e->getMessage());
		}
		
        if ($this->client->getLastResponse()->getStatus() != 201) {
            throw new Opentaps_Resource_Exception($responseObj->response->message);
        }

        return $responseObj->lead;
    }
*/
/*
    function setClient($client) {
        if (!$client instanceof Opentaps_Rest_Client) {
             throw new Opentaps_Resource_Exception('Failed to set a client.');
        }

    	$this->client = $client;
    	$this->client->setResourcePath(self::PATH);
    }
    
    
    function setEncType($encType = null) {
    	if ($encType != null) {
    		$this->encType = $encType;
    	}
    }
    */
}

?>
