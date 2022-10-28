<?php

namespace App\Tests\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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
     * @return void
     * @see https://docs.guzzlephp.org/en/stable/testing.html?highlight=test#mock-handler
     */
    protected function assertClientOneRequest(
        string $expectedReqMethod,
        string $expectedReqUri,
        string $expectedReqBody,
        array $actualRequestsSpy
    ): void
    {
        $this::assertCount(1, $actualRequestsSpy);
        /** @var Request $actualRequest */
        $actualRequest = $actualRequestsSpy[0]['request'];
        $this::assertSame($expectedReqMethod, $actualRequest->getMethod());
        $this::assertSame($expectedReqUri, (string)$actualRequest->getUri());
        $this::assertSame($expectedReqBody, (string)$actualRequest->getBody());
    }

    /**
     * Mock Guzzle Client
     *
     * @param Response $expectedResponse
     * @param array $spy
     * @return Client
     * @see https://docs.guzzlephp.org/en/stable/testing.html?highlight=test#mock-handler
     */
    protected function mockClient(Response $expectedResponse, array &$spy): Client
    {
        $mock = new MockHandler([$expectedResponse]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push(Middleware::history($spy));
        $client = new Client(['handler' => $handlerStack]);
        return $client;
    }
}