<?php

namespace App\Tests\Api;

use App\Dto\RetrieveCompanyQuotesNotificationDto;

class MainFormNotificationsTest extends AbstractMainFormTestCase
{
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

        $expectedEmailNotification = new RetrieveCompanyQuotesNotificationDto();
        $expectedEmailNotification->recipient = 'some@email.com';
//        $expectedEmailNotification->forCompanyName = '2001-02-03';
        $expectedEmailNotification->startDate = '2001-01-11';
        $expectedEmailNotification->endDate = '2001-02-03';
        $this->assertEmailHasBeenSent($expectedEmailNotification);
    }

    private function assertEmailHasNotBeenSent()
    {
        self::assertEmpty($this->getQuoteRetrievalNotifierSpy()->getNotifications());
    }

    private function assertEmailHasBeenSent(RetrieveCompanyQuotesNotificationDto $expectedNotification)
    {
        self::assertCount(1, $notifications = $this->getQuoteRetrievalNotifierSpy()->getNotifications());
        self::assertEquals(
            $expectedNotification,
            $notifications[0]
        );
    }
}
