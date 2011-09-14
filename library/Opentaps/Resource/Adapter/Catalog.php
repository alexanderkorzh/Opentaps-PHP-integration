<?php

require_once 'Opentaps/Resource/Adapter/Abstract.php';
require_once 'Opentaps/Resource/Exception.php';


class Opentaps_Resource_Adapter_Catalog extends Opentaps_Resource_Adapter_Abstract {

	const TYPE   		  = 'CATALOG';
	const PATH			  = "/stores";
	

    function __construct() {
        $this->path = self::PATH;
    }
    
    function getStores() {
        $responseObj = $this->request('GET');

        // JSON returns an array of objects,
        // so we reassign those to be directly accessible via products property
        if (isset($responseObj->response->stores)) {
            $responseObj->response->stores = $responseObj->response->data->store;
        } else {
            $responseObj->response->stores = array();
        }

        return $responseObj->response;
//		var_dump($this->client->getLastRequest());
    }

    function getCategories() {
        $this->setResourcePath(self::PATH . "/10000/catalogs/SpsCatalog/categories");
        $responseObj = $this->request('GET');

        // JSON returns an array of objects,
        // so we reassign those to be directly accessible via products property
        if (isset($responseObj->response->data)) {
            $responseObj->response->categories = $responseObj->response->data->category;
        } else {
            $responseObj->response->categories = array();
        }

        return $responseObj->response;
//		var_dump($this->client->getLastRequest());
    }

}

?>
