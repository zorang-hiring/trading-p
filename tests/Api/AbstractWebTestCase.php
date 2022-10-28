<?php

namespace App\Tests\Api;

use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{

    protected function assertResponseJsonContent(array $expectedJson, Response $response): void
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedJson),
            $actual = $response->getContent(),
            sprintf('Expected JSON "%s" not equal to "%s"', json_encode($expectedJson), $actual)
        );
    }

    protected function assertResponseHasStatus(int $expectedStatus, Response $actualResponse): void
    {
        $this->assertSame($expectedStatus, $actualResponse->getStatusCode());
    }

    protected function setCurrentDate(string $testNow): void
    {
        Carbon::setTestNow($testNow);
    }
}