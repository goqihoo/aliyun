<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;
use Goqihoo\Aliyun\Ons\Response;

class Producer extends AuthorizedClient
{

    /**
     * ProducerID for ONS
     *
     * @var string $pic
     */
    public $producerId;

    /**
     * Message body
     *
     * @var string
     */
    private $body;

    /**
     * send message to ONS
     *
     * @param string $topic
     * @param string $producerId
     * @param string $body
     * @return Response
     */
    public function produce($topic = '', $producerId = '', $body = '')
    {
        $this->time         = $this->getTime();
        $this->topic        = $topic;
        $this->producerId   = $producerId;
        $this->body         = $body;
        $client = new HttpClient();
        $request = $client->post($this->makeRequestUrl(), array(), $body)
                    ->addHeader('AccessKey', $this->getAuthorization()->getAccessKey())
                    ->addHeader('Signature', $this->getSignature())
                    ->addHeader('ProducerId', $this->producerId);
        $response = $client->send($request);
        return new Response($response);
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
     * Set producer body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set producerId
     *
     * @param string $producerId
     * @return $this
     */
    public function setProducerId($producerId)
    {
        $this->producerId = $producerId;
        return $this;
    }

    /**
     * Make signature for authorized request
     *
     * @return string
     */
    public function getSignature()
    {
        $signString= sprintf("%s\n%s\n%s\n%d", $this->topic, $this->producerId, md5($this->body), $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessSecret(), true));
    }
}

