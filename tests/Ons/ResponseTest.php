<?php

namespace Goqihoo\Aliyun\Ons;

use \GuzzleHttp\Psr7\Response as HttpResponse;

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
        $this->assertEquals(Response::$status[403], $response->getErrorMessage());
    }
}