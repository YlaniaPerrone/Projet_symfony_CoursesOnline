<?php

namespace App\Security;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class Mailer
{
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('test@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Create password!')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('registration/email.html.twig')
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ]);

        $mailer->send($email);

        // ...
    }
}