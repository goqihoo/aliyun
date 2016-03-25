<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Message\Response as HttpResponse;

class Response
{

    /**
     * Aliyun response status code
     *
     * @const int
     */
    const STATUS_PRODUCE_OK     = 201;
    const STATUS_CONSUME_OK     = 200;
    const STATUS_DELETE_OK      = 204;

    const STATUS_FAILED         = 400;
    const STATUS_DENY           = 403;
    const STATUS_TIMEOUT        = 408;

    /**
     * message list
     *
     * @var array
     */
    public static $status = array(
        self::STATUS_PRODUCE_OK => 'Produce Success',
        self::STATUS_CONSUME_OK => 'Consume Success',
        self::STATUS_DELETE_OK  => 'Delete Success',

        self::STATUS_FAILED     => 'Request Failed',
        self::STATUS_DENY       => 'Request Denied',
        self::STATUS_TIMEOUT    => 'Request Timeout',
    );

    /**
     * Response from http
     *
     * @var HttpResponse
     */
    public $response;

    /**
     * Response messages
     *
     * @var
     */
    public $messages;

    /**
     * Error message response from ONS
     *
     * @var string
     */
    public $errorMessage;

    /**
     * Initialize
     *
     * @param HttpResponse $response
     */
    public function __construct(HttpResponse $response)
    {
        $this->response = $response;
        if ($this->isSuccessful()) {
            $this->messages = new MessageGroup(json_decode($this->response->getBody(), true));
        }
    }

    /**
     * Check response content is successful or not
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $statusCode = $this->response->getStatusCode();
        if ($statusCode == self::STATUS_CONSUME_OK
            || $statusCode == self::STATUS_DELETE_OK
            || $statusCode == self::STATUS_PRODUCE_OK) {
            return true;
        }
        $this->errorMessage = self::$status[$statusCode];
        return false;
    }

    /**
     * Check response content is error or not
     *
     * @return boolean
     */
    public function isError()
    {
        return !$this->isSuccessful();
    }

    /**
     * Messages response by ONS
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Get error message response from ONS
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
