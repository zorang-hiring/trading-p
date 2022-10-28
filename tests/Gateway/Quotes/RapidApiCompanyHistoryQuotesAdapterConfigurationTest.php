<?php

namespace App\Tests\Gateway\Quotes;

use App\Gateway\Quotes\CompanyHistoryQuotesAdapterInterface;
use App\Gateway\Quotes\RapidApiCompanyHistoryQuotesAdapter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RapidApiCompanyHistoryQuotesAdapterConfigurationTest extends WebTestCase
{
    public function testConfiguration()
    {
        /** @var RapidApiCompanyHistoryQuotesAdapter $adapter */
        $adapter = $this->getContainer()->get(CompanyHistoryQuotesAdapterInterface::class);
        self::assertInstanceOf(RapidApiCompanyHistoryQuotesAdapter::class, $adapter);
        self::assertSame(
            ['key' => 'someRapidApiKey', 'host' => 'someRapidApiHost'],
            $adapter->getCredentials()
        );
    }
}
