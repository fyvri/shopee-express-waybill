<?php

use PHPUnit\Framework\TestCase;
use AzisAlvriyanto\ShopeeExpressWaybill\ShopeeExpressWaybill;
use AzisAlvriyanto\ShopeeExpressWaybill\CurlWrapper;

class ShopeeExpressWaybillTest extends TestCase
{
    private $mockCurl;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockCurl = $this->getMockBuilder(CurlWrapper::class)
            ->onlyMethods(['init', 'setopt', 'exec', 'errno', 'error', 'getinfo', 'close'])
            ->getMock();

        $this->mockCurl->method('init')->willReturn(true);
    }

    public function testCheckSuccessfulResponse()
    {
        $this->mockCurl->method('exec')->willReturn(json_encode(['retcode' => 0, 'data' => 'some_tracking_data']));
        $this->mockCurl->method('errno')->willReturn(0);
        $this->mockCurl->method('error')->willReturn('');
        $this->mockCurl->method('getinfo')->willReturn(200);

        $shopeeExpressWaybill = new ShopeeExpressWaybill($this->mockCurl);
        $response = $shopeeExpressWaybill->check('valid_tracking_number');

        $this->assertIsObject($response);
        $this->assertTrue($response->success);
        $this->assertEquals('Shipping number found', $response->message);
        $this->assertEquals('some_tracking_data', $response->data);
    }

    public function testCheckTrackingNotFound()
    {
        $this->mockCurl->method('exec')->willReturn(json_encode(['retcode' => 1]));
        $this->mockCurl->method('errno')->willReturn(0);
        $this->mockCurl->method('error')->willReturn('');
        $this->mockCurl->method('getinfo')->willReturn(200);

        $shopeeExpressWaybill = new ShopeeExpressWaybill($this->mockCurl);
        $response = $shopeeExpressWaybill->check('invalid_tracking_number');

        $this->assertIsObject($response);
        $this->assertFalse($response->success);
        $this->assertEquals('Shipping number not found', $response->message);
        $this->assertNull($response->data);
    }

    public function testCheckCurlError()
    {
        $this->mockCurl->method('exec')->willReturn(false);
        $this->mockCurl->method('errno')->willReturn(28); // Timeout error code
        $this->mockCurl->method('error')->willReturn('Timeout was reached');

        $shopeeExpressWaybill = new ShopeeExpressWaybill($this->mockCurl);
        $response = $shopeeExpressWaybill->check('any_tracking_number');

        $this->assertIsObject($response);
        $this->assertFalse($response->success);
        $this->assertEquals('Timeout was reached', $response->message);
        $this->assertNull($response->data);
    }

    public function testCheckHttpErrorResponse()
    {
        $this->mockCurl->method('exec')->willReturn(json_encode(['retcode' => 0, 'data' => null]));
        $this->mockCurl->method('errno')->willReturn(0);
        $this->mockCurl->method('error')->willReturn('');
        $this->mockCurl->method('getinfo')->willReturn(404); // Not Found HTTP status

        $shopeeExpressWaybill = new ShopeeExpressWaybill($this->mockCurl);
        $response = $shopeeExpressWaybill->check('non_existent_tracking_number');

        $this->assertIsObject($response);
        $this->assertFalse($response->success);
        $this->assertEquals('Failed to retrieve data, HTTP status code: 404', $response->message);
        $this->assertNull($response->data);
    }
}
