<?php

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SubmitMainFormTest extends WebTestCase
{
    public function testReturnErrorWhenFieldsNotPosted(): void
    {
        // WHEN
        $client = static::createClient();
        $client->request('POST', '/api/main-form');

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(400, $response);
        $this->assertResponseJsonContent(
            [
                'status' => 'NOK',
                'message' => 'Invalid Request',
                'errors' => [
                    'companySymbol' => ['This value should not be blank.'],
                    'startDate' => ['This value should not be blank.'],
                    'endDate' => ['This value should not be blank.'],
                    'email' => ['This value should not be blank.']
                ]
            ],
            $response
        );
    }

    public function testReturnErrorWhenFieldsAreInIvalidFormat(): void
    {
        // WHEN
        $client = static::createClient();
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'a',
            'startDate' => 'b',
            'endDate' => 'c',
            'email' => 'd',
        ]);

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(400, $response);
        $this->assertResponseJsonContent(
            [
                'status' => 'NOK',
                'message' => 'Invalid Request',
                'errors' => [
                    'startDate' => ['Accepted date format is YYYY-MM-DD.'],
                    'endDate' => ['Accepted date format is YYYY-MM-DD.'],
                    'email' => ['This value is not a valid email address.']
                ]
            ],
            $response
        );
    }

    public function testReturnErrorWhenEndDateIsLessThenStartDate(): void
    {
        // WHEN
        $client = static::createClient();
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'a',
            'startDate' => '2001-02-04',
            'endDate' => '2001-02-03',
            'email' => 'some@email.com',
        ]);

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(400, $response);
        $this->assertResponseJsonContent(
            [
                'status' => 'NOK',
                'message' => 'Invalid Request',
                'errors' => [
                    'startDate' => ['Has to be less or equal then endDate.'],
                    'endDate' => ['Has to be greater or equal then startDate.'],
                ]
            ],
            $response
        );
    }

    protected function assertResponseHasStatus(int $expectedStatus, Response $actualResponse): void
    {
        $this->assertSame($expectedStatus, $actualResponse->getStatusCode());
    }

    public function assertResponseJsonContent(array $expectedJson, Response $response): void
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedJson),
            $actual = $response->getContent(),
            sprintf('Expected JSON "%s" not equal to "%s"', json_encode($expectedJson), $actual)
        );
    }
}
