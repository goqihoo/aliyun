<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;

class Confirmation extends AuthorizedClient
{

    /**
     * Message handler from ONS
     *
     * @var string $consumerId
     */
    public $messageHandle;

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
     * @param string $messageHandle
     * @return Response
     */
    public function confirm($topic = '', $consumerId = '', $messageHandle = '')
    {
        $this->time           = $this->getTime();
        $this->topic          = $topic;
        $this->consumerId     = $consumerId;
        $this->messageHandle = $messageHandle;
        $client = new HttpClient();
        $request = $client->delete($this->makeRequestUrl().'&msgHandle='.$this->messageHandle)
            ->addHeader('AccessKey', $this->getAuthorization()->getAccessKey())
            ->addHeader('Signature', $this->getSignature())
            ->addHeader('ConsumerId', $this->consumerId);
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
        $signString= sprintf("%s\n%s\n%s\n%d", $this->topic, $this->consumerId, $this->messageHandle, $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessSecret(), true));
    }
}