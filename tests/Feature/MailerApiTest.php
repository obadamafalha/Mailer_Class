<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Services\Mailer;
use SendGrid;

class MailerApiTest extends TestCase
{
    public function testSendEmailViaMailgun()
    {
        // Set up the Mailer with Mailgun API credentials

        $mailer = new Mailer();
        $mailer->useMailgun('your-mailgun-api-key', 'your-mailgun-domain');

        $to = 'recipient@example.com';
        $subject = 'Test Subject';
        $message = 'Test Message';

        $response = $mailer->sendMailgunEmail($to, $subject, $message);

        $this->assertTrue($response);
    }


    public function testSendEmailViaSendGrid()
    {
        // Set up the Mailer with SendGrid API credentials
        $mailer = new Mailer();
        $mailer->useSendGrid('your-sendgrid-api-key');
        $mailer->setSubject('Test Subject');
        $mailer->setHTMLBody('Test Message');
        $mailer->addTo('recipient@example.com', 'Recipient Name');

        $response = $mailer->send();

        $this->assertTrue($response);
    }
}
