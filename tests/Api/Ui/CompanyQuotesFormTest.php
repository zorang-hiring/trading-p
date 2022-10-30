<?php

namespace App\Tests\Api\Ui;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyQuotesFormTest extends WebTestCase
{
    public function testFormIsPresentedOnHomePage()
    {
        // WHEN
        $client = static::createClient();
        $client->request('GET', '/');

        // THEN
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Company Quotes');
        $this->assertSelectorExists('form');
    }
}