<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Message\Response as HttpResponse;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testIsSuccessful()
    {
        $httpResponse = new HttpResponse(200);
        $response = new Response($httpResponse);
        $this->assertTrue($response->isSuccessful());

        $httpResponse = new HttpResponse(403);
        $response = new Response($httpResponse);
        $this->assertTrue($response->isError());
        $this->assertEquals(Response::$messages[403], $response->getErrorMessage());
    }

    public function testToArray()
    {
        $data = array('test');
        $httpResponse = new HttpResponse(200);
        $httpResponse->setBody(json_encode($data));
        $response = new Response($httpResponse);
        $this->assertEquals($data, $response->toArray());
    }
}