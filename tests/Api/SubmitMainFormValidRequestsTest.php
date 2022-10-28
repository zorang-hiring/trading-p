<?php

namespace App\Tests\Api;

class SubmitMainFormValidRequestsTest extends AbstractSubmitMainFormTestCase
{
    public function testReturnSuccessOnValidRequest(): void
    {
        // GIVEN
        $companySymbol = 'AAL';
        $this->setCurrentDate('2001-02-05');
        $client = static::createClient();
        $this->mockCompanyAdapters();
        $this->setCompanyQuotesStubData([
            // before range
            // in range
            [
                "date" => 1666970264,
                "open" => 2.2,
                "high" => 4.4,
                "low" => 1.1,
                "close" => 3.3,
                "volume" => 5
            ]
            // after range
        ]);

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => $companySymbol,
            'startDate' => '2001-01-11',
            'endDate' => '2001-02-03',
            'email' => 'some@email.com',
        ]);

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(200, $response);
        $this->assertSame(['companySymbol' => $companySymbol], $this->getCompanyQuotesAdapterRequestParams());
        $this->assertResponseJsonContent(
            [
                'status' => 'OK',
                'message' => '',
                'errors' => [],
                'data' => [
                    [
                        "date" => 1666970264,
                        "open" => 2.2,
                        "high" => 4.4,
                        "low" => 1.1,
                        "close" => 3.3,
                        "volume" => 5
                    ]
                ]
            ],
            $response
        );
    }

    public function testEmailHasBeenSentOnValidRequest(): void
    {
        $this->markTestIncomplete();
    }

    protected function setCompanyQuotesStubData(array $data): void
    {
        $this->getCompanyQuotesAdapter()->setStubData($data);
    }

    protected function getCompanyQuotesAdapterRequestParams(): array
    {
        return $this->getCompanyQuotesAdapter()->getRequestedParamsSpy();
    }
}
