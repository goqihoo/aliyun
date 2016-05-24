<?php

namespace Goqihoo\Aliyun\Ons;

use Goqihoo\Aliyun\Authorization;
use \GuzzleHttp\Client as HttpClient;

abstract class AuthorizedClient
{

    /**
     * ONS server url
     *
     * @var string
     */
    public $url;

    /**
     * Request time
     *
     * @var double $time
     */
    public $time;

    /**
     * Topic for ONS
     *
     * @var string $topic
     */
    public $topic;

    /**
     * Aliyun Authorization
     *
     * @var Authorization
     */
    private $authorization;

    /**
     * Request timeout
     *
     * @var int
     */
    private $timeout;

    /**
     * Show http errors or not
     */
    private $showHttpErrors = true;

    /**
     * Initialize
     *
     * @param string $url
     * @param Authorization $authorization
     */
    public function __construct($url, Authorization $authorization)
    {
        $this->url = $url;
        $this->authorization = $authorization;
    }

    /**
     * Set timeout for response
     *
     * @param int $timeout
     */
    public function setTimeout($timeout = null)
    {
        if ($timeout !== null) {
            $this->timeout = $timeout;
        }
    }

    /**
     * Get timeout of response
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Disable throw http exception
     *
     * @return void
     */
    public function disableHttpErrors()
    {
        $this->showHttpErrors = false;
    }

    /**
     * Get authorization from producer
     *
     * @return Authorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * Build http client
     *
     * @return HttpClient
     */
    public function getHttpClinet()
    {
        $options = array();
        if ($this->getTimeout() > 0) {
            $options['timeout'] = $this->getTimeout();
        }
        $options['http_errors'] = $this->showHttpErrors;
        return new HttpClient($options);
    }

    /**
     * Get microtime
     *
     * @return double
     */
    public function getTime()
    {
        list($usec, $sec) = explode(' ', microtime());
        return intval($usec * 1000) + $sec * 1000;
    }

    /**
     * Set produce time
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Set topic
     *
     * @param string $topic
     * @return $this
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * Make request url
     *
     * @return string
     */
    public function makeRequestUrl()
    {
        return sprintf("%s?topic=%s&time=%d", $this->url, $this->topic, $this->time);
    }
}