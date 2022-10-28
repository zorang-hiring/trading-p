<?php

namespace App\Tests\Gateway\CompanyList;

use App\Entity\CompaniesList;
use App\Entity\Company;
use App\Gateway\CompanyList\CompanyListAdapterInterface;
use App\Gateway\CompanyList\DataHubNasdaqCompanyListAdapter;
use App\Tests\Gateway\AbstractGatewayTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DataHubNasdaqCompanyListAdapterConfigurationTest extends WebTestCase
{
    public function testConfiguration()
    {
        $adapter = $this->getContainer()->get(CompanyListAdapterInterface::class);
        self::assertInstanceOf(DataHubNasdaqCompanyListAdapter::class, $adapter);
    }
}
