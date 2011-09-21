<?php

require_once 'Opentaps/Resource/Adapter/Abstract.php';
require_once 'Opentaps/Resource/Exception.php';


class Opentaps_Resource_Adapter_Product extends Opentaps_Resource_Adapter_Abstract {

    /**
     * Resource path relative to the web service
     */
	const RESOURCE_PATH_PRODUCTS = "/products";
	

    /**
     * Construct the adaptor
     */
    function __construct() {
//        $this->path = self::RESOURCE_PATH;
    }

    /**
     * Retrieve products
     *
     * @param string $storeId Store ID, mandatory
     * @param string $catalogId Catalog ID, mandatory
     * @param string $categoryId Category ID, optional, if not supplied returns all Products in Catalog
     * @param date $since Last Updated Date, optional, if not supplied returns all Products in Catalog
     * @return object
    */
    function getProducts($storeId = '', $catalogId = '', $categoryId = '', $since = null) {
        /** @var stdClass $r->response */

        $this->setResourcePath(sprintf(self::RESOURCE_PATH_PRODUCTS, $storeId, $catalogId));
        $r = $this->request('GET', 'product');

        return $r->response;
    }

}

?>
