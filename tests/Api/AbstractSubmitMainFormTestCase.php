<?php

namespace App\Tests\Api;

use App\Service\CompanyListAdapter\CompanyListAdapterInterface;
use App\Tests\Service\CompanyService\CompanyServiceAdapterStub;

abstract class AbstractSubmitMainFormTestCase extends AbstractWebTestCase
{
    protected function mockCompanyListAdapter(): void
    {
        $this->getContainer()->set(
            CompanyListAdapterInterface::class,
            new CompanyServiceAdapterStub()
        );
    }
}
