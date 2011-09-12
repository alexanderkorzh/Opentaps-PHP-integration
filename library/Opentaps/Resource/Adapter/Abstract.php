<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Abstract.php 23252 2010-10-26 12:48:32Z matthew $
 */


/**
 * @see Zend_Db
 */
//require_once 'Opentaps/Resource.php';

/**
 * Class for connecting to SQL databases and performing common operations.
 *
 * @category   Zend
 * @package    Zend_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Opentaps_Resource_Adapter_Abstract {

    /** @var Opentaps_Rest_Client $client */
    protected $client;
    protected $encType;
    protected $path;

    protected $config = array(
        'encType' => 'application/xml',
    );


    public function __construct($config) {
    	return $this;
    }


    function setClient($client) {
        if (!$client instanceof Opentaps_Rest_Client) {
             throw new Opentaps_Resource_Exception('Failed to set a client.');
        }

    	$this->client = $client;
    	$this->client->setResourcePath($this->path);
    }


    function setEncType($encType = null) {
    	if ($encType != null) {
    		$this->encType = $encType;
    	}
    }
    
}
