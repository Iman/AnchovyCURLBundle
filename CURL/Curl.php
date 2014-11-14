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

class Curl extends AbstractCurl
{

    /**
     * Configuration params
     *
     * @access private
     * @var array
     */
    private static $params;

    /**
     * CURL Object
     *
     * @access private
     * @var object
     */
    private static $instance;

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
     * @access private
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @access public
     * @throws \InvalidArgumentException Curl not installed.
     */
    public function __construct($params)
    {

        self::$params = $params;
        
        $this->options = array();

        if (function_exists('curl_version')) {

            self::$instance = curl_init();
        } else {
            throw new \InvalidArgumentException("Curl not installed.");
        }
    }

    /**
     * Setting the URL address
     *
     * @access public
     * @method setURL
     * @param string $url URL i.e http://localhost
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
     * @access private
     * @method getURL
     * @return string
     */
    private function getURL()
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

        curl_setopt_array(self::$instance, self::getOptions());

        if (!$curl = curl_exec(self::$instance)) {
            $error = self::getError();
            throw new \InvalidArgumentException("Error: {$error['error']} and the Error no is: {$error['error_no']} ");
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
            curl_setopt(self::$instance, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            curl_setopt(self::$instance, CURLOPT_POSTFIELDS, $postQuery);

            return $this;
        } catch (\Exception $exc) {

  			echo "Caught exception: ".  $exc->getMessage(). "\n";
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

        $this->execute();
        return curl_getinfo(self::$instance);
    }

    /**
     * Getting all the available options
     *
     * @access private
     * @method getOptions
     * @return mix
     */
    private function getOptions()
    {

        if (ini_get('safe_mode') || ini_get('open_basedir'))
            self::$curlFollowLocation = False;

        if (self::isUrlHttps($this->getURL()))
            self::$curlSSLVerify = True;

        $opts = array(
            CURLOPT_URL => $this->getURL(),
            CURLOPT_HTTPHEADER => self::$params['http_header'],
            CURLOPT_RETURNTRANSFER => self::$params['return_transfer'],
            CURLOPT_MAXREDIRS => self::$params['max_redirects'],
            CURLOPT_TIMEOUT => self::$params['timeout'],
            CURLOPT_CONNECTTIMEOUT => self::$params['connect_timeout'],
            CURLOPT_FOLLOWLOCATION => self::$params['follow_location'],
            CURLOPT_CRLF => self::$params['crlf'],
            CURLOPT_SSLVERSION => self::$params['ssl_version'],
            CURLOPT_SSL_VERIFYPEER => self::$params['ssl_verify']
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
     * @access private
     * @method getError
     * @return mix
     */
    private function getError()
    {

        if (curl_errno(self::$instance) > 0) {
            return array(
                'error_no' => curl_errno(self::$instance),
                'error' => curl_error(self::$instance)
            );
        }
        return false;
    }

    /**
     * Validating/Checking the HTTP or HTTPS from given URL
     *
     * @param string $url
     * @access private
     * @method isUrlHttps
     * @return boolean/string
     */
    private static function isUrlHttps($url)
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
        if (is_resource(self::$instance)) {
            $this->url = null;
            curl_close(self::$instance);
        }
    }

}
