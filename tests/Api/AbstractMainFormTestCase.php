<?php

namespace App\Tests\Api;

use App\Gateway\CompanyListGateway\CompanyListAdapterInterface;
use App\Gateway\QuotesGateway\CompanyHistoryQuotesAdapterInterface;
use App\Service\QuotesRetrievalNotifierInterface;
use App\Tests\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterSpy;
use App\Tests\Service\CompanyService\CompanyServiceAdapterStub;
use App\Tests\Service\QuotesRetrievalNotifierSpy;

abstract class AbstractMainFormTestCase extends AbstractWebTestCase
{
    private function mockCompanyListAdapter(): void
    {
        $this->getContainer()->set(
            CompanyListAdapterInterface::class,
            new CompanyServiceAdapterStub()
        );
    }

    private function mockCompanyQuotesAdapter(): void
    {
        $this->getContainer()->set(
            CompanyHistoryQuotesAdapterInterface::class,
            new CompanyHistoryQuotesAdapterSpy()
        );
    }

    protected function mockAdapters()
    {
        $this->mockCompanyListAdapter();
        $this->mockCompanyQuotesAdapter();
        $this->resetCompanyQuotesAdapterSpy();
        $this->mockQuoteRetrievalNotifier();
    }

    private function resetCompanyQuotesAdapterSpy(): void
    {
        $this->getCompanyQuotesAdapter()->reset();
    }

    protected function getCompanyQuotesAdapter(): CompanyHistoryQuotesAdapterSpy
    {
        /** @var CompanyHistoryQuotesAdapterSpy $adapter */
        $adapter = $this->getContainer()->get(
            CompanyHistoryQuotesAdapterInterface::class,
        );
        return $adapter;
    }

    protected function getQuoteRetrievalNotifierSpy(): QuotesRetrievalNotifierSpy
    {
        /** @var QuotesRetrievalNotifierSpy $object */
        $object = $this->getContainer()->get(
            QuotesRetrievalNotifierInterface::class,
        );
        return $object;
    }

    private function mockQuoteRetrievalNotifier(): void
    {
        $this->getContainer()->set(
            QuotesRetrievalNotifierInterface::class,
            new QuotesRetrievalNotifierSpy()
        );
    }
}
