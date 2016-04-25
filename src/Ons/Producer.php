<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;

class Producer extends AuthorizedClient
{

    /**
     * ProducerID for ONS
     *
     * @var string $pic
     */
    public $producerId;

    /**
     * Message for send
     *
     * @var Message
     */
    private $message;

    /**
     * send message to ONS
     *
     * @param string $topic
     * @param string $producerId
     * @param Message $message
     * @return Response
     */
    public function produce($topic = '', $producerId = '', $message)
    {
        $this->time         = $this->getTime();
        $this->topic        = $topic;
        $this->producerId   = $producerId;
        $this->message      = $message;
        $client = $this->getHttpClinet();
        $request = $client->post($this->makeRequestUrl(), array(), $message->getBody())
                    ->addHeader('AccessKey', $this->getAuthorization()->getAccessKey())
                    ->addHeader('Signature', $this->getSignature())
                    ->addHeader('ProducerId', $this->producerId);
        $response = $client->send($request);
        return new Response($response);
    }

    /**
     * Set message for produce
     *
     * @parame Message $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
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
        $signString= sprintf("%s\n%s\n%s\n%d", $this->topic, $this->producerId, md5($this->message->getBody()), $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessSecret(), true));
    }
}

