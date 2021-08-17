<?php

namespace App\Tests\Mailer;

use App\Entity\User;
use App\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('aime@aime.com');

        $swiftMailer = $this->createMock(MailerInterface::class);

        $twigMock = $this->createMock(\Twig\Environment::class);

        /*
        $swiftMailer->expects($this->once())->method('send')
        ->with($this->callback(function ($subject) {
            $messageStr = $subject;
            return true;
        }));

        */

        $twigMock->expects($this->once())->method('render')
            ->with(
                'email/registration.html.twig', 
                [ 'user' => $user ]
            );

        $mailer = new Mailer($swiftMailer, $twigMock, 'aim@aim.com');
        $mailer->sendConfirmationEmail($user);

    }
}