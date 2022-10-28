<?php

namespace App\Tests\Api;

class SubmitMainFormValidRequestsTest extends AbstractSubmitMainFormTestCase
{
    public function testReturnSuccessOnValidRequest(): void
    {
        // GIVEN
        $this->setCurrentDate('2001-02-05');
        $client = static::createClient();
        $this->mockCompanyAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'AAL',
            'startDate' => '2001-02-03',
            'endDate' => '2001-02-03',
            'email' => 'some@email.com',
        ]);

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(200, $response);
        $this->assertResponseJsonContent(
            [
                'status' => 'OK',
                'message' => '',
                'errors' => []
            ],
            $response
        );
    }
}
