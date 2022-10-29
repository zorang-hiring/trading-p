<?php

namespace App\Tests\Api\ComapnyQuotes;

use App\Gateway\CompanyList\CompanyListAdapterInterface;
use App\Gateway\Quotes\CompanyHistoryQuotesAdapterInterface;
use App\Tests\Api\AbstractWebTestCase;
use App\Tests\Gateway\CompanyList\CompanyListAdapterStub;
use App\Tests\Gateway\Quotes\CompanyHistoryQuotesAdapterSpy;

abstract class AbstractTestCase extends AbstractWebTestCase
{
    protected const API_URL = '/api/company-quotes';

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
