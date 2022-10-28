<?php

namespace App\Tests\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class AbstractGatewayTestCase extends TestCase
{
    /**
     * Assert that Gateway Client has made one specific request
     *
     * @param array $actualRequestsSpy Guzzle requests container
     * @param string $expectedReqMethod
     * @param string $expectedReqUri
     * @param string $expectedReqBody
     * @param array $expectedReqHeaders
     * @return void
     * @see https://docs.guzzlephp.org/en/stable/testing.html?highlight=test#mock-handler
     */
    protected function assertClientOneRequest(
        string $expectedReqMethod,
        string $expectedReqUri,
        string $expectedReqBody,
        array $expectedReqHeaders,
        array $actualRequestsSpy
    ): void
    {
        $this::assertCount(1, $actualRequestsSpy);
        /** @var Request $actualRequest */
        $actualRequest = $actualRequestsSpy[0]['request'];
        $this::assertSame($expectedReqMethod, $actualRequest->getMethod());
        $this::assertSame($expectedReqUri, (string)$actualRequest->getUri());
        $this::assertSame($expectedReqBody, (string)$actualRequest->getBody());
        foreach ($expectedReqHeaders as $name => $value) {
            $this::assertSame(is_array($value) ? $value : [$value], $actualRequest->getHeader($name));
        }
    }

    /**
     * Mock Guzzle Client
     *
     * @param Response $expectedResponse
     * @param array $spy Usually empty array, will be filled since its reference. Will spy Client requests.
     * @return Client
     * @see https://docs.guzzlephp.org/en/stable/testing.html?highlight=test#mock-handler
     */
    protected function mockClient(Response $expectedResponse, array &$spy): Client
    {
        $mock = new MockHandler([$expectedResponse]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push(Middleware::history($spy));
        return new Client(['handler' => $handlerStack]);
    }

    /**
     * @param MockObject $mock Any object which has "getClient" method (to be mocked)
     * @param Response $expectedResponse
     * @param array $spy Usually empty array, will be filled since its reference. Will spy Client requests.
     * @return void
     */
    protected function mockGetClientOnce(MockObject $mock, Response $expectedResponse, array &$spy): void
    {
        $mock
            ->expects(self::once())
            ->method('getClient')
            ->willReturn(
                $this->mockClient(
                    $expectedResponse,
                    $spy
                )
            );
    }
}