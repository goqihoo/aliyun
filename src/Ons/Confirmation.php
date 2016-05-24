<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class Confirmation extends AuthorizedClient
{

    /**
     * Message for confirmation
     *
     * @var Message $message
     */
    public $message;

    /**
     * ConsumerId on Aliyun
     *
     * @var string $consumerId
     */
    public $consumerId;

    /**
     * Confirm message from ONS
     *
     * @param string $topic
     * @param string $consumerId
     * @param Message $message
     * @return Response
     */
    public function confirm($topic = '', $consumerId = '', Message $message)
    {
        $this->time           = $this->getTime();
        $this->topic          = $topic;
        $this->consumerId     = $consumerId;
        $this->message        = $message;
        $url = $this->makeRequestUrl().'&msgHandle='.$message->getMessageHandle();
        $client = $this->getHttpClinet();
        $request = new Request('DELETE', $url, array(
            'AccessKey'  => $this->getAuthorization()->getAccessKey(),
            'Signature'  => $this->getSignature(),
            'ConsumerId' => $this->consumerId,
        ));
        $response = $client->send($request);
        return new Response($response);
    }

    /**
     * Make signature for authorized request
     *
     * @return string
     */
    public function getSignature()
    {
        $signString= sprintf("%s\n%s\n%s\n%d", $this->topic, $this->consumerId, $this->message->getMessageHandle(), $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessSecret(), true));
    }
}