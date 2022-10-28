<?php

namespace App\Tests\Api;

use App\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyListAdapter\CompanyListAdapterInterface;
use App\Service\QuoteRetrievalNotifierInterface;
use App\Tests\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterSpy;
use App\Tests\Service\CompanyService\CompanyServiceAdapterStub;
use App\Tests\Service\QuoteRetrievalNotifierSpy;

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

    protected function getQuoteRetrievalNotifierSpy(): QuoteRetrievalNotifierSpy
    {
        /** @var QuoteRetrievalNotifierSpy $object */
        $object = $this->getContainer()->get(
            QuoteRetrievalNotifierInterface::class,
        );
        return $object;
    }

    private function mockQuoteRetrievalNotifier(): void
    {
        $this->getContainer()->set(
            QuoteRetrievalNotifierInterface::class,
            new QuoteRetrievalNotifierSpy()
        );
    }

    protected function setCompanyQuotesStubData(array $data): void
    {
        $this->getCompanyQuotesAdapter()->setStubData($data);
    }
}
