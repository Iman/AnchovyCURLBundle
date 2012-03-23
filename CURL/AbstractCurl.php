<?php

/*
 * This file is part of the AnchovyCURLBundle package.
 *
 * (c)  Iman Samizadeh <http://github.com/Iman/AnchovyCURLBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package       Anchovy
 * @subpackage    CURLBundle
 * @author        Iman Samizadeh <iman@imanpage.com>  http://imanpage.com
 */

namespace Anchovy\CURLBundle\CURL;

/**
 *
 * @abstract
 */
abstract class AbstractCurl {

    /**
     * CURLOPT_RETURNTRANSFER
     *
     * @abstract
     * @access protected
     * @var boolean
     */
    protected static $curlReturnTransfer = TRUE;

    /**
     * CURLOPT_FOLLOWLOCATION
     *
     * @abstract
     * @access protected
     * @var boolean
     */
    protected static $curlFollowLocation = TRUE;

    /**
     * CURLOPT_MAXREDIRS
     *
     * @abstract
     * @access protected
     * @var int
     */
    protected static $curlmaxRedirects = 5;

    /**
     * CURLOPT_TIMEOUT
     *
     * @abstract
     * @access protected
     * @var int
     */
    protected static $curlTimeout = 25;

    /**
     * CURLOPT_CONNECTTIMEOUT
     *
     * @abstract
     * @access protected
     * @var int
     */
    protected static $curlConnectTTimeout = 25;

    /**
     * CURLOPT_HTTPHEADER
     *
     * @abstract
     * @access protected
     * @var array
     */
    protected static $curlHTTPHeader = array("Expect:");

    /**
     * CURLOPT_CRLF
     *
     * @abstract
     * @access protected
     * @var boolean
     */
    protected static $curlCRLF = TRUE;

    /**
     * CURLOPT_SSLVERSION
     *
     * @abstract
     * @access protected
     * @var int
     */
    protected static $curlSSLVersion = 3;

    /**
     * CURLOPT_SSL_VERIFYPEER
     *
     * @abstract
     * @access protected
     * @var boolean
     */
    protected static $curlSSLVerify = 0;

    /**
     * Options
     *
     * @abstract
     * @access private
     * @var array
     */
    private $options;

    /**
     * This method is to execute the CURL
     *
     * @abstract
     * @access public
     * @method execute
     */
    abstract public function execute();

    /**
     * Setting the URL
     *
     * @param string $url URL i.e http://localhost
     * @abstract
     * @access public
     * @method setURL
     */
    abstract public function setURL($url);

    /**
     * Getting the cURL information
     *
     * @abstract
     * @access public
     * @method getInfo
     * @return array
     */
    public function getInfo() {
        return array();
    }

    /**
     * setOption method is to introduce a single option to cURL
     * i.e setOption('CURLOPT_VERBOSE', True).
     *
     * @param string $key i.e  'CURLOPT_VERBOSE'
     * @param mix $value (True/False, int or string)
     * @abstract
     * @access public
     * @method setOption
     * @return array
     */
    public function setOption($key, $value) {
        return $this->options[$key] = $value;
    }

    /**
     * setOptions method is to introduce multioption to cURL
     *
     * i.e
     *
     * $options = array(
     * 'CURLOPT_VERBOSE' => True,
     * 'CURLOPT_NOBODY' => True,
     * 'CURLOPT_BINARYTRANSFER' => false);
     *
     *  $this->curl->setOptions($options)->execute();
     *
     * @param array $options
     * @abstract
     * @access public
     * @method setOptions
     * @return array
     */
    public function setOptions(array $options = array()) {
        return $this->options = $options;
    }

    /**
     * This is to set the cURL method type like POST, GET, PUT or DELETE
     *
     * @param string $method i.e POST
     * @param array $param An array needs to be set to this method i.e array('Filed' => 'Value'))
     * @abstract
     * @access public
     * @method setMethod
     * @return object \Anchovy\CURLBundle\CURL\AbstractCurl
     */
    public function setMethod($method = 'POST', array $param = array()) {
        return $this;
    }

}
