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

        // TODO remove, temporary solution for prices and else, has to be implemented in OT
        for ($i = 0; $i < count($r->response->dataset); $i++) {
            if (
                (!isset($r->response->dataset[$i]->isActive) || $r->response->dataset[$i]->isActive == "N") ||
                $r->response->dataset[$i]->isVirtual == "Y"
            ) {
                array_splice($r->response->dataset, $i, 1);
                $i--;
                continue;
            }

            $r->response->dataset[$i]->prices = array(
                'listPrice' => 0,
                'basePrice' => 0,
                'defaultPrice' => $r->response->dataset[$i]->price,
            );

            if (isset($r->response->dataset[$i]->longDescription)) {
                $r->response->dataset[$i]->longDescription = str_ireplace("&#xd;", "", $r->response->dataset[$i]->longDescription);
            }

/*
Phones and Terminals:       1   SPS-PNT-#####
Iridium
Inmarsat
Emergency Equipment:        2   SPS-EE-#####
Voice and Data Services:    3   SPS-SVC-#####
Accessories                 4
Antennas:                   5   SPS-ANT-#####
Cables and Adapters:        6   SPS-CNA-#####
Cases and Holsters:         7   SPS-CSE-#####
Chargers and Batteries:     8   SPS-CNB-#####
Docking Stations:           9   SPS-DOC-#####
Hands-Free:                 10  SPS-HDF-#####
Handsets:                   11  SPS-HND-#####
Manuals:                    12  SPS-MAN-#####
Mounting Solutions:         13  SPS-MNT-#####
Various:                    14  SPS-VAR-#####
*/

            $categories = array(
                'SPS-PNT' => 1,
                'SPS-EE'  => 2,
                'SPS-SVC' => 3,
                'SPS-ANT' => 5,
                'SPS-CNA' => 6,
                'SPS-CSE' => 7,
                'SPS-CNB' => 8,
                'SPS-DOC' => 9,
                'SPS-HDF' => 10,
                'SPS-HND' => 11,
                'SPS-MAN' => 12,
                'SPS-MNT' => 13,
                'SPS-VAR' => 14,
            );

            preg_match("/^[^-]+-[^-]+/", $r->response->dataset[$i]->productId, $matches);
//            var_dump('$matches', $matches);
            $categoryIdBySKU = $matches[0];

            if (array_key_exists($categoryIdBySKU, $categories)) {
                $r->response->dataset[$i]->primaryProductCategoryId = (String) $categories[$categoryIdBySKU];
            }
        }

        return $r->response;
    }

}

?>
