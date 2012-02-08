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

class Curl extends AbstractCurl {

    private static $instance;
    protected $url;
    private $options;
    private $info = array();
    private $error = array();

    public function __construct() {

        if (function_exists('curl_version')) {

            self::$instance = curl_init();
        } else {
            throw new \InvalidArgumentException("Curl not installed.");
        }
    }

    public function setURL($url) {
        $this->url = $url;
        return $this;
    }

    private function getURL() {
        return $this->url;
    }

    public function execute() {

        curl_setopt_array(self::$instance, self::getOptions());

        if (!curl_exec(self::$instance)) {
            $error = self::getError();
            throw new \InvalidArgumentException("Error: {$error['error']} and the Error no is: {$error['error_no']} ");
        }

        $this->info = curl_getinfo(self::$instance);
        
        return $this;
    }

    public function setOption($key, $value) {
        $this->options[$key] = $value;
        return $this;
    }

    public function setOptions(array $options = array()) {
        $this->options = $options;
        return $this;
    }

    public function setMethod($method = 'POST', array $param = array()) {

        try {
            $postQuery = http_build_query($param);
            curl_setopt(self::$instance, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            curl_setopt(self::$instance, CURLOPT_POSTFIELDS, $postQuery);

            return $this;
        } catch (Exception $exc) {

            throw $exc;
        }
    }

    public function getInfo() {

        return $this->info;
    }

    private function getOptions() {

        if (ini_get('safe_mode') || ini_get('open_basedir'))
            self::$curlFollowLocation = False;

        if (self::isUrlHttps($this->getURL()))
            self::$curlSSLVerify = True;

        $opts = array(
            CURLOPT_URL => $this->getURL(),
            CURLOPT_HTTPHEADER => self::$curlHTTPHeader,
            CURLOPT_RETURNTRANSFER => self::$curlReturnTransfer,
            CURLOPT_MAXREDIRS => self::$curlmaxRedirects,
            CURLOPT_TIMEOUT => self::$curlTimeout,
            CURLOPT_CONNECTTIMEOUT => self::$curlConnectTTimeout,
            CURLOPT_FOLLOWLOCATION => self::$curlFollowLocation,
            CURLOPT_CRLF => self::$curlCRLF,
            CURLOPT_SSLVERSION => self::$curlSSLVersion,
            CURLOPT_SSL_VERIFYPEER => self::$curlSSLVerify
        );

        if (!empty($this->options)) {
            foreach ($this->options as $key => $val) {
                $opts[constant(strtoupper($key))] = $val;
            }
        }
        return $opts;
    }

    private function getError() {

        if (curl_errno(self::$instance) > 0) {
            return array(
                'error_no' => curl_errno(self::$instance),
                'error' => curl_error(self::$instance)
            );
        }
        return false;
    }

    private static function isUrlHttps($url) {
        return preg_match('/^https:\/\//', $url);
    }

    final public function __destruct() {
        if (is_resource(self::$instance)) {
            $this->url = null;
            curl_close(self::$instance);
        }
    }

}