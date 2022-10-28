<?php

namespace App\Tests\Gateway\Quotes;

use App\Entity\Quote;
use App\Entity\QuotesList;
use App\Gateway\Quotes\RapidApiCompanyHistoryQuotesAdapter;
use App\Tests\Gateway\AbstractGatewayTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use GuzzleHttp\Psr7\Response;

class RapidApiCompanyHistoryQuotesAdapterTest extends AbstractGatewayTestCase
{
    protected RapidApiCompanyHistoryQuotesAdapter|MockObject $sut;

    protected const EXPECTED_REQUEST_HEADERS = [
        'X-RapidAPI-Key' => 'someKey',
        'X-RapidAPI-Host' => 'someHost'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = self::getMockBuilder(RapidApiCompanyHistoryQuotesAdapter::class)
            ->setConstructorArgs(['someKey', 'someHost'])
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
                ['Content-Type' => 'application/json'],
                file_get_contents(__DIR__ . '/../_fixtures/RapidApiCompanyHistoryQuotes.json')
            ),
            $spy
        );

        // EXPECTED
        self::expectException(\RuntimeException::class);

        // WHEN
        $this->sut->getQuotes('someSymbol');

        // THEN
        $this->assertClientOneRequest(
            'GET',
            'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=someSymbol&region=US',
            '',
            self::EXPECTED_REQUEST_HEADERS,
            $spy
        );
    }

    public function testGetCompaniesSuccess()
    {
        // GIVEN
        $spy = [];
        $this->mockGetClientOnce(
            $this->sut,
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                file_get_contents(__DIR__ . '/../_fixtures/RapidApiCompanyHistoryQuotes.json')
            ),
            $spy
        );


        // WHEN
        $actualResult = $this->sut->getQuotes('someSymbol');

        // THEN

        $expectedResult = new QuotesList();
        foreach ([
            ['date' => 11, 'open' => 21.2, 'close' => 51.5, 'low' => 41.4, 'high' => 31.3, 'volume' => 61],
            ['date' => 12, 'open' => 22.2, 'close' => 52.5, 'low' => 42.4, 'high' => 32.3, 'volume' => 62],
        ] as $q) {
            $quote = new Quote();
            $quote->date = $q['date'];
            $quote->open = $q['open'];
            $quote->close = $q['close'];
            $quote->low = $q['low'];
            $quote->high = $q['high'];
            $quote->volume = $q['volume'];
            $expectedResult->addQuote($quote);
        }
        self::assertEquals($expectedResult, $actualResult);

        $this->assertClientOneRequest(
            'GET',
            'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=someSymbol&region=US',
            '',
            self::EXPECTED_REQUEST_HEADERS,
            $spy
        );
    }
}
