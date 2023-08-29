<?php

namespace App\Services;


use PHPMailer\PHPMailer\PHPMailer;
use SendGrid\Mail\Mail as SendGridMail;
use Mailgun\Mailgun;

class Mailer
{
    private $mailer, $subject, $domain;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
    }

    public function setSMTPAuth($host, $username, $password, $port = 587)
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
        $this->mailer->Port = $port;
    }

    public function setHTMLBody($body)
    {
        $this->mailer->isHTML(true);
        $this->mailer->Body = $body;
    }

    public function setAltBody($altBody)
    {
        $this->mailer->AltBody = $altBody;
    }

    public function addAttachment($path, $name = '')
    {
        $this->mailer->addAttachment($path, $name);
    }

    public function validate($address)
    {
        return $this->mailer->validateAddress($address);
    }

    public function send()
    {
        $this->mailer->Subject = $this->subject;
        return $this->mailer->send();
    }

    // Other methods for customization and flexibility

    // Method to switch between APIs
    public function useSendGrid($apiKey)
    {
        $this->mailer = new SendGridMail();
        $this->mailer->setFrom('test@example.com', 'Test Sender');
        $this->mailer->setSubject($this->subject);
        // Set other common properties here

        // Set SendGrid API key
        $this->mailer->addHeader('Authorization', 'Bearer ' . $apiKey);
    }

    public function useMailgun($apiKey, $domain)
    {
        $this->mailer = Mailgun::create($apiKey);
        $this->domain = $domain;
        
    }
    public function sendMailgunEmail($to, $subject, $message)
    {
        // Construct the message
        $result = $this->mailer->messages()->send($this->domain, [
            'from' => 'sender@example.com',
            'to' => $to,
            'subject' => $subject,
            'text' => $message,
        ]);

        // Handle the result
        if ($result->http_response_code == 200) {
            return true; // Email sent successfully
        } else {
            return false; // Email sending failed
        }
    }
    // Method to add recipients
    public function addTo($email, $name)
    {
        $this->mailer->addAddress($email, $name);
    }

    public function addCc($email, $name)
    {
        $this->mailer->addCC($email, $name);
    }

    public function addBcc($email, $name)
    {
        $this->mailer->addBCC($email, $name);
    }

    // Method to embed images
    public function embedImage($path, $cid)
    {
        // Implement image embedding logic
    }

    // Method to handle errors and warnings
    public function getErrorMessages()
    {
        return $this->mailer->ErrorInfo;
    }
    public function setSubject($subject)
    {
        $this->subject = $subject;
        $this->mailer->Subject = $subject;
    }
}
