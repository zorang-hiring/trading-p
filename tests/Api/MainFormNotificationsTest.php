<?php

namespace App\Tests\Api;

use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotificationDto;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;

class MainFormNotificationsTest extends AbstractMainFormTestCase
{
    use MailerAssertionsTrait;

    public function testEmailNotSentOnInvalidRequest()
    {
        // GIVEN
        $this->setCurrentDate('2001-02-04');
        $client = static::createClient();
        $this->mockAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => 'AAIT',
            'startDate' => '2001-02-04',
            'endDate' => '2001-02-03',
            'email' => 'some@email.com',
        ]);

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(400, $response);
        $this->assertEmailHasNotBeenSent();
    }

    public function testEmailHasBeenSentOnValidRequest(): void
    {
        // GIVEN
        $companySymbol = 'AAL';
        $this->setCurrentDate('2001-02-05');
        $client = static::createClient();
        $this->mockAdapters();

        // WHEN
        $client->request('POST', '/api/main-form', [
            'companySymbol' => $companySymbol,
            'startDate' => '2001-01-11',
            'endDate' => '2001-02-03',
            'email' => 'some@email.com',
        ]);

        // THEN
        $response = $client->getResponse();
        $this->assertResponseHasStatus(200, $response);

        $expectedEmailNotification = new QuotesRetrievalNotificationDto();
        $expectedEmailNotification->recipient = 'some@email.com';
        $expectedEmailNotification->forCompanyName = 'American Airlines Group, Inc.';
        $expectedEmailNotification->startDate = '2001-01-11';
        $expectedEmailNotification->endDate = '2001-02-03';
        $this->assertEmailHasBeenSent($expectedEmailNotification);
    }

    private function assertEmailHasNotBeenSent()
    {
        $this->assertEmailCount(0);
    }

    private function assertEmailHasBeenSent(QuotesRetrievalNotificationDto $expectedNotification)
    {
        $this->assertEmailCount(1);

        $email = $this->getMailerMessage();

        self::assertStringContainsString(
            'To: ' . $expectedNotification->recipient,
            $email->toString()
        );
        self::assertStringContainsString(
            'Subject: ' . $expectedNotification->forCompanyName,
            $email->toString()
        );

        $body = sprintf('From %s to %s', $expectedNotification->startDate, $expectedNotification->endDate);
        $this->assertEmailTextBodyContains($email, $body);
        $this->assertEmailHtmlBodyContains($email, $body);
    }
}
