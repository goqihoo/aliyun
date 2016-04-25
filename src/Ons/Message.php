<?php
namespace Goqihoo\Aliyun\Ons;

class Message
{

    /**
     * The data response by ONS
     *
     * @var array $data
     */
    private $data;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * Get unique message id
     *
     * @return string
     */
    public function getMessageId()
    {
        return $this->data['msgId'];
    }

    /**
     * Get message content
     *
     * @return string
     */
    public function getBody()
    {
        return $this->data['body'];
    }

    /**
     * Set body content
     *
     * @return void
     */
    public function setBody($body)
    {
        $this->data['body'] = $body;
    }

    /**
     * Get message making time
     *
     * @return int
     */
    public function getBornTime()
    {
        return intval($this->data['bornTime']);
    }

    /**
     * Get the time of re-consume message
     *
     * @return int
     */
    public function getReConsumeTimes()
    {
        return intval($this->data['reconsumeTimes']);
    }

    /**
     * Get message handle string
     * used in delete message
     */
    public function getMessageHandle()
    {
        return $this->data['msgHandle'];
    }

    /**
     * Transform to array
     */
    public function toArray()
    {
        return array(
            'messageId'     => $this->getMessageId(),
            'body'          => $this->getBody(),
            'bornTime'      => $this->getBornTime(),
            'messageHandle' => $this->getMessageHandle(),
            'reConsumeTimes'=> $this->getReConsumeTimes(),
        );
    }
}