<?php

namespace App\Tests\Api;

use App\Gateway\CompanyList\CompanyListAdapterInterface;
use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotifierInterface;
use App\Gateway\Quotes\CompanyHistoryQuotesAdapterInterface;
use App\Tests\Gateway\CompanyList\CompanyListAdapterStub;
use App\Tests\Gateway\DataRetrievalNotifier\QuotesRetrievalNotifierSpy;
use App\Tests\Gateway\Quotes\CompanyHistoryQuotesAdapterSpy;

abstract class AbstractMainFormTestCase extends AbstractWebTestCase
{
    private function mockCompanyListAdapter(): void
    {
        $this->getContainer()->set(
            CompanyListAdapterInterface::class,
            new CompanyListAdapterStub()
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
