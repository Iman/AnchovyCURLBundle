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

abstract class AbstractCurl {

    protected static $curlReturnTransfer = false;
    protected static $curlFollowLocation = True;
    protected static $curlmaxRedirects = 5;
    protected static $curlTimeout = 25;
    protected static $curlConnectTTimeout = 25;
    protected static $curlHTTPHeader = array("Expect:");
    protected static $curlCRLF = true;
    protected static $curlSSLVersion = 3;
    protected static $curlSSLVerify = 0;
    private $options;

    abstract public function execute();

    abstract public function setURL($url);

    public function getInfo() {
        return array();
    }

    public function setOption($key, $value) {
        return $this->options[$key] = $value;
    }

    public function setOptions(array $options = array()) {
        return $this->options = $options;
    }

    public function setMethod($method = 'POST', array $param = array()) {
        return $this;
    }

}
