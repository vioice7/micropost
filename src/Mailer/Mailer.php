<?php

namespace App\Mailer;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $mailFrom;
    
    public function __construct(
        MailerInterface $mailer, 
        \Twig\Environment $twig, 
        string $mailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    public function sendConfirmationEmail(User $user)
    {
                        //$event->getRegisteredUser();

                        $body = $this->twig->render('email/registration.html.twig', [
                            'user' => $user,
                
                        ]);
                
                        $message = (new Email())
                        ->from($this->mailFrom)
                        ->to($user->getEmail())
                        //->cc('cc@example.com')
                        //->bcc('bcc@example.com')
                        //->replyTo('fabien@example.com')
                        //->priority(Email::PRIORITY_HIGH)
                        ->subject('Micro Post')
                        //->text('Micro Post')
                        ->html($body);
                
                        $this->mailer->send($message);
    }
}