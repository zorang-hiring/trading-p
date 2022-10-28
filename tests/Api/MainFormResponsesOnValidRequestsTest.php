<?php

namespace App\Tests\Api;

class MainFormResponsesOnValidRequestsTest extends AbstractMainFormTestCase
{
    public function testReturnValidDataOnValidRequest(): void
    {
        // GIVEN
        $companySymbol = 'AAL';
        $this->setCurrentDate('2001-02-05');
        $client = static::createClient();
        $this->mockAdapters();
        $this->setCompanyQuotesStubData([
            // before range:
            [
                "date" => $this->dateTimeToUnix('2001-01-10 23:59:59'),
                "open" => 2.1,
                "high" => 4.1,
                "low" => 1.1,
                "close" => 3.1,
                "volume" => 51
            ],
            // in range:
            [
                "date" => $this->dateTimeToUnix('2001-01-11 00:00:00'),
                "open" => 2.21,
                "high" => 4.21,
                "low" => 1.21,
                "close" => 3.21,
                "volume" => 521
            ],
            [
                "date" => $this->dateTimeToUnix('2001-02-03 23:59:59'),
                "open" => 2.22,
                "high" => 4.22,
                "low" => 1.22,
                "close" => 3.22,
                "volume" => 522
            ],
            // after range:
            [
                "date" => $this->dateTimeToUnix('2001-02-04 00:00:00'),
                "open" => 2.3,
                "high" => 4.3,
                "low" => 1.3,
                "close" => 3.3,
                "volume" => 53
            ]
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
                        "date" => 979171200,
                        "open" => 2.21,
                        "high" => 4.21,
                        "low" => 1.21,
                        "close" => 3.21,
                        "volume" => 521
                    ],
                    [
                        "date" => 981244799,
                        "open" => 2.22,
                        "high" => 4.22,
                        "low" => 1.22,
                        "close" => 3.22,
                        "volume" => 522
                    ]
                ]
            ],
            $response
        );
    }

    protected function getCompanyQuotesAdapterRequestParams(): array
    {
        return $this->getCompanyQuotesAdapter()->getRequestedParamsSpy();
    }

    /**
     * @param string $dateTime In "Y-m-d H:i:s" format
     * @return int
     */
    protected function dateTimeToUnix(string $dateTime): int
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime)->getTimestamp();
    }

    /**
     * @param string $date In "Y-m-d" format
     * @return int
     */
    protected function dateToUnix(string $date): int
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $date . ' 12:00:00')->getTimestamp();
    }

    protected function setCompanyQuotesStubData(array $data): void
    {
        $this->getCompanyQuotesAdapter()->setStubData($data);
    }
}
