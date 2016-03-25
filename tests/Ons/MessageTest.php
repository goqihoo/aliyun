<?php

namespace Goqihoo\Aliyun\Tests\Ons;

use Goqihoo\Aliyun\Ons\Message;
use Goqihoo\Aliyun\Ons\MessageGroup;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return array
     */
    public function getServerResponseString()
    {
        return array(
            array(
                '[{"body":"HelloMQ",
                "bornTime":"1418973464204",
                "msgHandle":"X1BFTkRJTkdNU0dfXyVSRVRSWSUkbG9uZ2ppJENJRF9sb25namlfdGxvbmdqaQ==",
                "msgId":"0A021F7300002A9F000000000647076D",
                "reconsumeTimes":1}]',
                array(
                    'body'          => 'HelloMQ',
                    'bornTime'      => 1418973464204,
                    'messageHandle' => 'X1BFTkRJTkdNU0dfXyVSRVRSWSUkbG9uZ2ppJENJRF9sb25namlfdGxvbmdqaQ==',
                    'messageId'     => '0A021F7300002A9F000000000647076D',
                    'reConsumeTimes'=> 1,
                ),
            ),
        );
    }

    /**
     * Test MessageGroup
     *
     * @param string $responseString
     * @param array $realInfo
     * @dataProvider getServerResponseString
     */
    public function testMessageGroup($responseString, $realInfo)
    {
        $messageGroup = new MessageGroup(json_decode($responseString, true));
        foreach ($messageGroup as $message) {
            $this->assertEquals($message->toArray(), $realInfo);
        }
    }

    /**
     * Test Message
     *
     * @param string $responseString
     * @param array $realInfo
     * @dataProvider getServerResponseString
     */
    public function testMessage($responseString, $realInfo)
    {
        $messages = json_decode($responseString, true);
        $message = new Message($messages[0]);
        $this->assertEquals($message->toArray(), $realInfo);
    }
}