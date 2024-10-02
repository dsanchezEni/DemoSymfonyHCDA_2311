<?php

namespace App\Notification;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class SenderService
{

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendNewUserNotificationToAdmin(UserInterface $user):void{
        //Pour tester
        file_put_contents("debug.txt",$user->getEmail());

        $message = new Email();
        $message->from('account@demo.com')
            ->to('admin@test.fr')
            ->subject('Nouvel utilisateur créé depuis le site de démo')
        ->html('<h1>Nouvel Utilisateur:</h1><p>Email : '.$user->getEmail().'</p>');
        $this->mailer->send($message);
    }
}