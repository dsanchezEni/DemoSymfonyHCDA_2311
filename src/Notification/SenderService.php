<?php

namespace App\Notification;

use Symfony\Component\Security\Core\User\UserInterface;

class SenderService
{
    public function sendNewUserNotificationToAdmin(UserInterface $user):void{
        //Pour tester
        file_put_contents("debug.txt",$user->getEmail());
    }
}