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

use Anchovy\CURLBundle\Exception\CurlException;

class Curl extends AbstractCurl
{
    /**
     * Configuration params
     *
     * @access protected
     * @var array
     */
    protected $params = [];

    /**
     * CURL Object
     *
     * @access protected
     * @var resource
     */
    protected $instance;

    /**
     * URL address
     *
     * @access protected
     * @var string
     */
    protected $url;

    /**
     * cURL array options
     *
     * @access protected
     * @var array
     */
    protected $options = [];

    /**
     * Constructor
     *
     * @access public
     * @throws \InvalidArgumentException Curl not installed.
     */
    public function __construct($params)
    {
        if (!function_exists('curl_version')) {
            throw new \InvalidArgumentException("Curl not installed.");
        }

        $this->params = $params;
        $this->instance = curl_init();
    }

    /**
     * Setting the URL address
     *
     * @access public
     * @method setURL
     * @param string $url URL e.g. http://localhost
     * @return object \Anchovy\CURLBundle\CURL\Curl
     */
    public function setURL($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Getting the URL
     *
     * @access protected
     * @method getURL
     * @return string
     */
    protected function getURL()
    {
        return $this->url;
    }

    /**
     * Execute method needs to be called to execute the cURL object
     *
     * @access public
     * @method execute
     * @return mix
     * @throws \InvalidArgumentException Error: xxxxx and the Error no is: 000000
     */
    public function execute()
    {
        curl_setopt_array($this->instance, $this->getOptions());

        if (!$curl = curl_exec($this->instance)) {
            $error = $this->getError();
            throw new CurlException($error['error'], $error['error_no']);
        }

        return $curl;
    }

    /**
     * setOption method is to introduce a single option to cURL
     * i.e setOption('CURLOPT_VERBOSE', True).
     *
     * @param string $key i.e  'CURLOPT_VERBOSE'
     * @param mix $value (True/False, int or string)
     * @access public
     * @method setOption
     * @return object \Anchovy\CURLBundle\CURL\Curl
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
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
     * @access public
     * @method setOptions
     * @return object \Anchovy\CURLBundle\CURL\Curl
     */
    public function setOptions(array $options = array())
    {
        $this->options = $options;
        return $this;
    }

    /**
     * This is to set the cURL method type like POST, GET, PUT or DELETE
     *
     * @param string $method i.e POST
     * @param array $param An array needs to be set to this method i.e array('Filed' => 'Value'))
     * @access public
     * @method setMethod
     * @return \Anchovy\CURLBundle\CURL\Curl
     * @throws Exception
     */
    public function setMethod($method = 'POST', array $param = array())
    {

        try {
            $postQuery = http_build_query($param);
            curl_setopt($this->instance, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            curl_setopt($this->instance, CURLOPT_POSTFIELDS, $postQuery);

            return $this;
        } catch (\Exception $exc) {

            echo "Caught exception: " . $exc->getMessage() . "\n";
        }
    }

    /**
     * Getting the cURL information
     *
     * @access public
     * @method getInfo
     * @return array
     */
    public function getInfo()
    {
        return curl_getinfo($this->instance);
    }

    /**
     * Getting all the available options
     *
     * @access protected
     * @method getOptions
     * @return mix
     */
    protected function getOptions()
    {
        $opts = array(
            CURLOPT_URL => $this->getURL(),
            CURLOPT_HTTPHEADER => $this->params['http_header'],
            CURLOPT_RETURNTRANSFER => $this->params['return_transfer'],
            CURLOPT_MAXREDIRS => $this->params['max_redirects'],
            CURLOPT_TIMEOUT => $this->params['timeout'],
            CURLOPT_CONNECTTIMEOUT => $this->params['connect_timeout'],
            CURLOPT_FOLLOWLOCATION => $this->params['follow_location'],
            CURLOPT_CRLF => $this->params['crlf'],
            CURLOPT_SSLVERSION => $this->params['ssl_version'],
        );

        if (!empty($this->options)) {
            foreach ($this->options as $key => $val) {
                $opts[constant(strtoupper($key))] = $val;
            }
        }
        return $opts;
    }

    /**
     * Getting the errors
     *
     * @access protected
     * @method getError
     * @return mix
     */
    protected function getError()
    {
        if (curl_errno($this->instance) > 0) {
            return array(
                'error_no' => curl_errno($this->instance),
                'error' => curl_error($this->instance)
            );
        }
        return false;
    }

    /**
     * Validating/Checking the HTTP or HTTPS from given URL
     *
     * @param string $url
     * @access protected
     * @method isUrlHttps
     * @return boolean/string
     */
    protected static function isUrlHttps($url)
    {
        return preg_match('/^https:\/\//', $url);
    }

    /**
     * Destroying the object
     *
     * @access public
     * @method __destruct
     * @return void
     */
    final public function __destruct()
    {
        if (is_resource($this->instance)) {
            $this->url = null;
            curl_close($this->instance);
        }
    }

}
