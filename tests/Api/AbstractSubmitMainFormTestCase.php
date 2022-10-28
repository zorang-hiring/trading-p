<?php

namespace App\Tests\Api;

use App\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyListAdapter\CompanyListAdapterInterface;
use App\Tests\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterSpy;
use App\Tests\Service\CompanyService\CompanyServiceAdapterStub;

abstract class AbstractSubmitMainFormTestCase extends AbstractWebTestCase
{
    private function mockCompanyListAdapter(): void
    {
        $this->getContainer()->set(
            CompanyListAdapterInterface::class,
            new CompanyServiceAdapterStub()
        );
    }

    private function mockCompanyHistoryQuotesAdapter(): void
    {
        $this->getContainer()->set(
            CompanyHistoryQuotesAdapterInterface::class,
            new CompanyHistoryQuotesAdapterSpy()
        );
    }

    protected function mockCompanyAdapters()
    {
        $this->mockCompanyListAdapter();
        $this->mockCompanyHistoryQuotesAdapter();
    }
}
