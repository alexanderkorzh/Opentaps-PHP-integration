<?php

require_once 'Opentaps/Resource/Adapter/Abstract.php';
require_once 'Opentaps/Resource/Exception.php';


class Opentaps_Resource_Adapter_Catalog extends Opentaps_Resource_Adapter_Abstract {

    /**
     * Resource path relative to the web service
     */
	const RESOURCE_PATH_STORES = '/stores';
	const RESOURCE_PATH_CATEGORIES = '/stores/%s/catalogs/%s/categories';


    /**
     * Construct the adaptor
     */
    function __construct() {
//        $this->path = self::RESOURCE_PATH;
    }
    
    /**
     * Retrieves all Stores available
     *
     * @return object
    */
    function getStores() {
        /** @var stdClass $r->response */

        $this->setResourcePath(self::RESOURCE_PATH_STORES);
        $r = $this->request('GET', 'store');

        return $r->response;
    }

    /**
     * Retrieves Catalogs for a given Store
     *
     * @param string $storeId Store ID, mandatory
     * @param date $since Last Updated Date, optional, if not supplied returns all Catalogs
     * @return object
    */
    function getCatalogs($storeId = '', $since = null) {
        // TODO implement the functionality
    }

    /**
     * Retrieves Categories for a given Catalog
     *
     * @param string $storeId Store ID, mandatory
     * @param string $catalogId Catalog ID, mandatory
     * @param date $since Last Updated Date, optional, if not supplied returns all Categories in Catalog
     * @return object
    */
    function getCategories($storeId = '', $catalogId = '', $since = null) {
        /** @var stdClass $r->response */

        if (empty($storeId)) {
            throw new Opentaps_Resource_Exception('A valid Store ID has to be supplied.');
        }

        if (empty($catalogId)) {
            throw new Opentaps_Resource_Exception('A valid Catalog ID has to be supplied.');
        }

        $this->setResourcePath(sprintf(self::RESOURCE_PATH_CATEGORIES, $storeId, $catalogId));
        $r = $this->request('GET', 'category');

        return $r->response;
    }

}

?>
