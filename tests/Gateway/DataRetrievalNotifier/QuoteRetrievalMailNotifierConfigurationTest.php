<?php

namespace App\Tests\Gateway\DataRetrievalNotifier;

use App\Gateway\DataRetrievalNotifier\QuotesRetrievalMailNotifier;
use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotifierInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteRetrievalMailNotifierConfigurationTest extends WebTestCase
{
    public function testConfiguration()
    {
        self::markTestIncomplete();

        /** @var QuotesRetrievalMailNotifier $adapter */
        $adapter = $this->getContainer()->get(QuotesRetrievalNotifierInterface::class);
        self::assertInstanceOf(QuotesRetrievalMailNotifier::class, $adapter);
        self::assertSame(
            ['key' => 'someRapidApiKey', 'host' => 'someRapidApiHost'],
            $adapter->getCredentials()
        );
    }
}
