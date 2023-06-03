<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendMailNotification;
use Illuminate\Support\Facades\Notification;

class MailController extends Controller
{
    public function sendEmail()
    {
        $user = auth()->user();

        Notification::send($user, new SendMailNotification());

        return "E-mail enviado com sucesso!";
    }
}
