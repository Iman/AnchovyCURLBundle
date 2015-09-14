<?php

namespace Anchovy\CURLBundle\Exception;

class CurlException extends \InvalidArgumentException
{
    protected $curlMessage;
    protected $curlErrorCode;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        $this->curlMessage = $message;
        $this->curlErrorCode = $code;

        parent::__construct("Error: {$message} and the Error no is: {$code} ", $code, $previous);
    }

    /**
     * @return string
     */
    public function getCurlMessage()
    {
        return $this->curlMessage;
    }

    /**
     * @return int
     */
    public function getCurlErrorCode()
    {
        return $this->curlErrorCode;
    }


}
