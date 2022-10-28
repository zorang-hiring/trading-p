<?php

namespace App\Tests\Api;

use App\Gateway\CompanyList\CompanyListAdapterInterface;
use App\Gateway\Quotes\CompanyHistoryQuotesAdapterInterface;
use App\Tests\Gateway\CompanyList\CompanyListAdapterStub;
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
}
