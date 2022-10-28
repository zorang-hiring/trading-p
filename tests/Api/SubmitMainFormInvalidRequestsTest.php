<?php

namespace App\Tests\Api;

use Carbon\Carbon;

class SubmitMainFormInvalidRequestsTest extends AbstractSubmitMainFormTestCase
{
    public function testReturnErrorWhenFieldsNotPosted(): void
    {
        // GIVEN
        $client = static::createClient();
        $this->mockCompanyAdapters();

        // WHEN
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
        // GIVEN
        $client = static::createClient();
        $this->mockCompanyAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'AAIT',
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
        // GIVEN
        Carbon::setTestNow(Carbon::createFromDate(2001, 2, 4));
        $client = static::createClient();
        $this->mockCompanyAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'AAIT',
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

    public function testReturnErrorWhenEndDateAndStartDateAreLessThenCurrentDate(): void
    {
        // GIVEN
        Carbon::setTestNow(Carbon::createFromDate(2001, 2, 2));
        $client = static::createClient();
        $this->mockCompanyAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'AAIT',
            'startDate' => '2001-02-03',
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
                    'startDate' => ['Has to be less or equal then current date.'],
                    'endDate' => ['Has to be less or equal then current date.'],
                ]
            ],
            $response
        );
    }

    public function testReturnErrorWhenCompanySymbolDoesNotExist(): void
    {
        // GIVEN
        Carbon::setTestNow(Carbon::createFromDate(2001, 2, 5));
        $client = static::createClient();
        $this->mockCompanyAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'ABCD',
            'startDate' => '2001-02-03',
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
                    'companySymbol' => ['The string "ABCD" is not valid Company Symbol.'],
                ]
            ],
            $response
        );
    }
}
