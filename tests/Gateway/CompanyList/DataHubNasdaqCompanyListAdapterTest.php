<?php

namespace App\Tests\Gateway\CompanyList;

use App\Entity\CompaniesList;
use App\Entity\Company;
use App\Gateway\CompanyList\DataHubNasdaqCompanyListAdapter;
use App\Tests\Gateway\AbstractGatewayTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use GuzzleHttp\Psr7\Response;

class DataHubNasdaqCompanyListAdapterTest extends AbstractGatewayTestCase
{
    protected DataHubNasdaqCompanyListAdapter|MockObject $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = self::getMockBuilder(DataHubNasdaqCompanyListAdapter::class)
            ->onlyMethods(['getClient'])
            ->getMock();
    }

    /**
     * @testWith [201]
     *           [300]
     *           [400]
     *           [500]
     */
    public function testGetCompaniesInvalidResponse($responseStatus)
    {
        // GIVEN
        $spy = [];
        $this->mockGetClientOnce(
            $this->sut,
            new Response(
                $responseStatus,
                ['Content-Type' => 'text/plain', 'Content-Encoding' => 'br'],
                file_get_contents(__DIR__ . '/../_fixtures/DataHubNasdaqCompanyList.json')
            ),
            $spy
        );

        // EXPECTED
        self::expectException(\RuntimeException::class);

        // WHEN
        $this->sut->getCompanies();
    }

    public function testGetCompaniesSuccess()
    {
        // GIVEN
        $spy = [];
        $this->mockGetClientOnce(
            $this->sut,
            new Response(
                200,
                ['Content-Type' => 'text/plain', 'Content-Encoding' => 'br'],
                file_get_contents(__DIR__ . '/../_fixtures/DataHubNasdaqCompanyList.json')
            ),
            $spy
        );


        // WHEN
        $actualResult = $this->sut->getCompanies();

        // THEN

        $expectedResult = new CompaniesList();
        $expectedResult->addCompany(new Company('AAIT', 'iShares MSCI All Country Asia Information Technology Index Fund'));
        $expectedResult->addCompany(new Company('AAL', 'American Airlines Group, Inc.'));
        self::assertEquals($expectedResult, $actualResult);

        $this->assertClientOneRequest(
            'GET',
            'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/' .
            'a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json',
            '',
            $spy
        );
    }
}
